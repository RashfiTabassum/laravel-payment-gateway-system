<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title','Auth')</title>
<style>
  :root {
    --bg:#0f1b2d;
    --card:#fff;
    --ink:#0f172a;
    --muted:#64748b;
    --brand:#0e2244;
  }
  * { box-sizing:border-box; }
  body {
    margin:0;
    background:var(--bg);
    font-family:ui-sans-serif,system-ui,Segoe UI,Roboto,Helvetica,Arial;
    color:var(--ink);
  }
  .wrap {
    min-height:100vh;
    display:grid;
    place-items:center;
    padding:24px;
  }
  .card {
    width:100%;
    max-width:420px;
    background:var(--card);
    border-radius:16px;
    padding:28px;
    box-shadow:0 10px 30px rgba(0,0,0,.18);
  }
  h1 {
    margin:0 0 10px 0;
    text-align:center;
    font-size:28px;
  }
  label {
    display:block;
    font-size:12px;
    color:#334155;
    margin-top:10px;
  }
  input, select {
    width:100%;
    padding:10px 12px;
    border:1px solid #cbd5e1;
    border-radius:10px;
    margin-top:6px;
  }
  .btn {
    display:block;
    width:100%;
    margin-top:16px;
    border:none;
    border-radius:10px;
    padding:12px 16px;
    color:#fff;
    background:var(--brand);
    font-weight:700;
  }
  .btn:hover {
    opacity:.95;
    cursor:pointer;
  }
  .muted {
    color:var(--muted);
    font-size:14px;
    text-align:center;
    margin-top:10px;
  }
  .alert {
    background:#fee2e2;
    border:1px solid #fecaca;
    color:#991b1b;
    border-radius:12px;
    padding:10px 12px;
    margin:10px 0;
  }
</style>
@yield('head')
</head>
<body>
  <div class="wrap">
    <div class="card">
      @yield('content')
    </div>
  </div>
</body>
</html>
