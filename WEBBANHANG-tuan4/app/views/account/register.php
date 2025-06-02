<?php include 'app/views/shares/header.php'; ?>
<?php
if (isset($errors) && count($errors) > 0) {
  echo "<ul style='list-style:none; padding-left:0; margin-bottom:20px;'>";
  foreach ($errors as $err) {
      echo "<li class='text-danger' style='font-weight:600; margin-bottom:5px;'>$err</li>";
  }
  echo "</ul>";
}
?>
<div style="max-width: 480px; margin: 40px auto; background: #ffffffdd; padding: 40px 40px; border-radius: 20px; box-shadow: 0 0 25px #00b3b3aa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #004d4d;">
  <h2 style="color:#007a7a; text-transform: uppercase; font-weight: 900; letter-spacing: 3px; margin-bottom: 30px; text-align:center;">Register</h2>
  <form action="/webbanhang/account/save" method="post" autocomplete="off" novalidate>
    <div style="display: flex; gap: 20px; flex-wrap: wrap;">
      <input
        type="text"
        id="username"
        name="username"
        placeholder="Username"
        required
        style="flex: 1 1 220px; padding: 14px 20px; border: 2px solid #00b3b3; border-radius: 30px; background: #e0fbfc; color: #004d4d; font-size: 1.1rem; font-weight: 500; letter-spacing: 1.2px; outline: none; transition: 0.3s;"
        onfocus="this.style.borderColor='#007a7a'; this.style.boxShadow='0 0 12px #007a7a';"
        onblur="this.style.borderColor='#00b3b3'; this.style.boxShadow='none';"
      />
      <input
        type="text"
        id="fullname"
        name="fullname"
        placeholder="Full Name"
        required
        style="flex: 1 1 220px; padding: 14px 20px; border: 2px solid #00b3b3; border-radius: 30px; background: #e0fbfc; color: #004d4d; font-size: 1.1rem; font-weight: 500; letter-spacing: 1.2px; outline: none; transition: 0.3s;"
        onfocus="this.style.borderColor='#007a7a'; this.style.boxShadow='0 0 12px #007a7a';"
        onblur="this.style.borderColor='#00b3b3'; this.style.boxShadow='none';"
      />
    </div>

    <div style="display: flex; gap: 20px; margin-top: 25px; flex-wrap: wrap;">
      <input
        type="password"
        id="password"
        name="password"
        placeholder="Password"
        required
        style="flex: 1 1 220px; padding: 14px 20px; border: 2px solid #00b3b3; border-radius: 30px; background: #e0fbfc; color: #004d4d; font-size: 1.1rem; font-weight: 500; letter-spacing: 1.2px; outline: none; transition: 0.3s;"
        onfocus="this.style.borderColor='#007a7a'; this.style.boxShadow='0 0 12px #007a7a';"
        onblur="this.style.borderColor='#00b3b3'; this.style.boxShadow='none';"
      />
      <input
        type="password"
        id="confirmpassword"
        name="confirmpassword"
        placeholder="Confirm Password"
        required
        style="flex: 1 1 220px; padding: 14px 20px; border: 2px solid #00b3b3; border-radius: 30px; background: #e0fbfc; color: #004d4d; font-size: 1.1rem; font-weight: 500; letter-spacing: 1.2px; outline: none; transition: 0.3s;"
        onfocus="this.style.borderColor='#007a7a'; this.style.boxShadow='0 0 12px #007a7a';"
        onblur="this.style.borderColor='#00b3b3'; this.style.boxShadow='none';"
      />
    </div>

    <div style="text-align: center; margin-top: 40px;">
      <button type="submit" style="
        width: 100%;
        padding: 15px 0;
        border: none;
        border-radius: 30px;
        font-weight: 900;
        font-size: 1.2rem;
        letter-spacing: 2px;
        color: #ffffff;
        background: linear-gradient(270deg, #00b3b3, #007a7a, #00b3b3);
        background-size: 600% 600%;
        animation: neonGradient 4s ease infinite;
        cursor: pointer;
        box-shadow: 0 0 20px #007a7a;
        transition: box-shadow 0.3s;
      " 
      onmouseover="this.style.boxShadow='0 0 40px #004d4d';" 
      onmouseout="this.style.boxShadow='0 0 20px #007a7a';"
      >Register</button>
    </div>
  </form>
</div>

<style>
  @keyframes neonGradient {
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
  }
  input::placeholder {
    color: #007a7aaa;
    font-weight: 500;
    font-size: 1.1rem;
    letter-spacing: 1.2px;
    font-style: normal;
  }
  a:hover {
    text-decoration: underline;
  }
  @media (max-width: 600px) {
    div[style*="flex-wrap: wrap;"] {
      flex-direction: column !important;
    }
    input {
      flex: 1 1 100% !important;
      margin-bottom: 15px;
    }
  }
</style>

<?php include 'app/views/shares/footer.php'; ?>
