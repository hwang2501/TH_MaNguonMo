<?php include 'app/views/shares/header.php'; ?>
<section style="height:100vh; background: linear-gradient(135deg, #c2f0f7, #e0fbfc, #f7fdfd); display:flex; justify-content:center; align-items:center; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
  <div style="background: #ffffffdd; border-radius: 20px; padding: 40px 50px; width: 380px; box-shadow: 0 0 25px #00b3b3aa;">
    <form action="/webbanhang/account/checklogin" method="post" autocomplete="off" style="color:#004d4d;">
      <h2 style="color:#007a7a; text-transform: uppercase; font-weight: 900; letter-spacing: 3px; margin-bottom: 30px; text-align:center;">LOGIN</h2>
      
      <!-- Username -->
      <div style="position: relative; margin-bottom: 30px;">
        <input 
          type="text" 
          name="username" 
          placeholder="Username" 
          required
          style="
            width: 100%; 
            padding: 14px 50px; 
            border: 2px solid #00b3b3; 
            border-radius: 30px; 
            background: #e0fbfc;
            color: #004d4d; 
            font-size: 1.1rem; 
            font-weight: 500;
            letter-spacing: 1.2px;
            transition: 0.3s;
            outline: none;
          "
          onfocus="this.style.borderColor='#007a7a'; this.style.boxShadow='0 0 12px #007a7a';"
          onblur="this.style.borderColor='#00b3b3'; this.style.boxShadow='none';"
        />
        <i class="fas fa-user" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #007a7a; font-size: 1.3rem;"></i>
      </div>
      
      <!-- Password -->
      <div style="position: relative; margin-bottom: 40px;">
        <input 
          type="password" 
          name="password" 
          placeholder="Password" 
          required
          style="
            width: 100%; 
            padding: 14px 50px; 
            border: 2px solid #00b3b3; 
            border-radius: 30px; 
            background: #e0fbfc;
            color: #004d4d; 
            font-size: 1.1rem; 
            font-weight: 500;
            letter-spacing: 1.2px;
            transition: 0.3s;
            outline: none;
          "
          onfocus="this.style.borderColor='#007a7a'; this.style.boxShadow='0 0 12px #007a7a';"
          onblur="this.style.borderColor='#00b3b3'; this.style.boxShadow='none';"
        />
        <i class="fas fa-lock" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #007a7a; font-size: 1.3rem;"></i>
      </div>
      
      <div style="text-align: right; margin-bottom: 30px;">
        <a href="#!" style="color:#007a7a; font-weight: 600; text-decoration:none; font-size: 0.9rem;">Forgot password?</a>
      </div>
      
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
      >LOGIN</button>

      <div style="margin-top: 35px; display: flex; justify-content: center; gap: 30px; font-size: 1.4rem;">
        <a href="#!" style="color:#007a7a;"><i class="fab fa-facebook-f"></i></a>
        <a href="#!" style="color:#007a7a;"><i class="fab fa-twitter"></i></a>
        <a href="#!" style="color:#007a7a;"><i class="fab fa-google"></i></a>
      </div>

      <p style="color:#007a7a; font-weight: 600; margin-top: 40px; text-align:center; font-size: 0.95rem;">
        Don't have an account? 
        <a href="/webbanhang/account/register" style="color:#004d4d; text-decoration:none; font-weight: 800;"> Sign Up</a>
      </p>
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
  </style>
</section>
<?php include 'app/views/shares/footer.php'; ?>
