<!DOCTYPE html>
<html>
<head>
  <title>AWS PHP MySQL Demo</title>
  <style>
    :root {
      --bg: #0b1220;
      --card: rgba(15, 26, 51, 0.8);
      --border: rgba(126, 249, 163, 0.2);
      --text: #fff;
      --neon: #7ef9a3;
      --neon2: #34d399;
      --danger: #ff5f5f;
    }

    * { box-sizing: border-box; }

    body {
      font-family: Arial, sans-serif;
      background: radial-gradient(circle at 20% 10%, rgba(126,249,163,0.15), transparent 55%),
                  radial-gradient(circle at 80% 70%, rgba(52,211,153,0.12), transparent 55%),
                  linear-gradient(135deg, #070b14, #0b1220);
      color: var(--text);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      overflow: hidden;
    }

    .container {
      width: 480px;
      padding: 28px;
      border-radius: 24px;
      background: var(--card);
      border: 1px solid var(--border);
      box-shadow: 0 30px 80px rgba(0,0,0,0.55);
      backdrop-filter: blur(10px);
      position: relative;
      overflow: hidden;
      animation: containerIn 0.8s ease both;
    }

    .container::before {
      content: "";
      position: absolute;
      inset: -50%;
      background: conic-gradient(from 0deg, rgba(126,249,163,0.0), rgba(126,249,163,0.25), rgba(52,211,153,0.15), rgba(126,249,163,0.0));
      animation: neonRotate 4.5s linear infinite;
      opacity: 0.7;
      pointer-events: none;
    }

    @keyframes neonRotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    @keyframes containerIn {
      from { opacity: 0; transform: translateY(18px) scale(0.98); }
      to { opacity: 1; transform: translateY(0) scale(1); }
    }

    h2 {
      margin: 0 0 16px;
      text-align: center;
      color: var(--neon);
      letter-spacing: 1px;
      position: relative;
      z-index: 1;
    }

    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid rgba(126,249,163,0.25);
      border-radius: 12px;
      outline: none;
      background: rgba(255,255,255,0.04);
      color: #fff;
      transition: all 0.25s ease;
      position: relative;
      z-index: 1;
    }

    input:focus {
      border-color: rgba(126,249,163,0.6);
      box-shadow: 0 0 16px rgba(126,249,163,0.25);
      background: rgba(255,255,255,0.06);
    }

    button {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      border: 1px solid rgba(126,249,163,0.4);
      border-radius: 12px;
      background: linear-gradient(135deg, rgba(126,249,163,0.95), rgba(52,211,153,0.8));
      color: #0b1220;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      position: relative;
      z-index: 1;
      overflow: hidden;
    }

    button:hover {
      transform: translateY(-1px);
      box-shadow: 0 0 18px rgba(126,249,163,0.5);
    }

    button:active {
      transform: translateY(1px) scale(0.99);
      box-shadow: 0 0 12px rgba(126,249,163,0.4);
    }

    .success, .error {
      padding: 10px;
      border-radius: 12px;
      text-align: center;
      margin-bottom: 10px;
      position: relative;
      z-index: 1;
      border: 1px solid rgba(255,255,255,0.2);
    }

    .success {
      background: rgba(126,249,163,0.2);
      color: #0b1220;
    }

    .error {
      background: rgba(255,204,0,0.22);
      color: #000;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      position: relative;
      z-index: 1;
    }

    th, td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid rgba(126,249,163,0.15);
    }

    /* Advanced animation: staggered row fade-in */
    .row {
      opacity: 0;
      transform: translateY(8px);
      animation: rowIn 0.6s ease forwards;
    }

    @keyframes rowIn {
      to { opacity: 1; transform: translateY(0); }
    }

    /* Loading effect */
    .loading {
      animation: loadingGlow 1.5s infinite ease-in-out;
    }

    @keyframes loadingGlow {
      0%, 100% { opacity: 0.55; }
      50% { opacity: 1; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Add Student</h2>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
      <div class="success">
        Student saved successfully!
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['status']) && $_GET['status'] === 'duplicate'): ?>
      <div class="error">
        Student already exists!
      </div>
    <?php endif; ?>

    <form action="logics/process-update.php" method="POST">
      <input type="text" name="name" placeholder="Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <button type="submit">Save</button>
    </form>

    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody id="studentTable">
        <tr>
          <td colspan="2" style="text-align:center;" class="loading">Loading...</td>
        </tr>
      </tbody>
    </table>
  </div>

  <script>
    async function loadStudents() {
      try {
        const res = await fetch('logics/fetch-students.php');

        if (!res.ok) {
          document.getElementById('studentTable').innerHTML =
            `<tr><td colspan="2" style="text-align:center;">Error loading students: ${res.status}</td></tr>`;
          return;
        }

        const data = await res.json();

        if (data.error) {
          document.getElementById('studentTable').innerHTML =
            `<tr><td colspan="2" style="text-align:center;">Error: ${data.error}</td></tr>`;
          return;
        }

        const tbody = document.getElementById('studentTable');
        tbody.innerHTML = '';

        data.forEach((student, index) => {
          const row = document.createElement('tr');
          row.classList.add('row');
          row.style.animationDelay = `${index * 0.08}s`;  // STAGGERED ANIMATION
          row.innerHTML = `<td>${student.name}</td><td>${student.email}</td>`;
          tbody.appendChild(row);
        });
      } catch (err) {
        document.getElementById('studentTable').innerHTML =
          `<tr><td colspan="2" style="text-align:center;">Error loading students: ${err.message}</td></tr>`;
      }
    }

    loadStudents();
  </script>
</body>
</html>
