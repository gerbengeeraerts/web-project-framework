<section class="modalContainer">
  <div class="closeModal"><img src="assets/images/close_icon.png"></div>
  <div class="modalContent">
    <div class="showModal signUpModal">
      <div class="modalContentContainer">
        <div class="modalContent">
          <header class="modalHeader">
            <h1>Create your account for free</h1>
          </header>
          <div class="modalMessage">
            <ul class="modalForm">
              <li>
                <input class="signUpUsername" type="text" name="username" placeholder="Username*" required>
              </li>
              <li>
                <input class="signUpEmail" type="email" name="email" placeholder="Email*" required>
              </li>
              <li>
                <input class="signUpPassword" type="password" name="password" placeholder="Password*" required>
              </li>
              <li>
                <input class="signUpReferral" type="text" name="referral" placeholder="Referral (Optional)">
              </li>
              <li>
                <label><input class="signUpTerms" type="checkbox" name="terms" required>
                Have you read and accepted our <a href="">Terms &amp; Guidelines?</a></label>
              </li>
              <li>
                <button class="button signUpComplete">Register account</button>
              </li>
            </ul>
          </div>
          <footer class="modalFooter">
            <p>Already have an account? <a href="">Log in</a>.</p>
          </footer>
        </div>
      </div>
    </div>

    <div class="showModal loginModal">
      <div class="modalContentContainer">
        <div class="modalContent">
          <header class="modalHeader">
            <h1>Log in to your account</h1>
          </header>
          <div class="modalMessage">
            <ul class="modalForm">
              <li>
                <input class="loginEmail" type="email" name="email" placeholder="Email" required>
              </li>
              <li>
                <input class="loginPassword" type="password" name="password" placeholder="Password" required>
              </li>
              <li>
                <button class="button logInComplete">Log in</button>
              </li>
            </ul>
          </div>
          <footer class="modalFooter">
            <p>Forgot your password? <a href="reset-account">Reset your password</a>.</p>
            <p>Need an account? <a href="">Register here</a>.</p>
          </footer>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="hero">
  <div class="heroContainer">
    <header class="heroHeader">
      <figure>
        <a href="home">
          <img src="assets/images/logo_petrolfest.png">
        </a>
      </figure>
    </header>
    <div class="heroContent">
      <div class="half">
        <h2>Free to play!</h2>
        <h1>Virtual Car Community</h1>
        <p>
          PetrolFest is the perfect place to race cars with your friends in an online car community.
          Buy, modify, upgrade and race your favorite cars together with friends in your own club.
          Bet credits or pink slips and win great prizes.
          A new festival opens every month with each its own parts and races.
        </p>
        <ul class="buttonList">
          <?php

          if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
            ?>
            <li>
              <a href="garage" class="button">
                Continue to garage
              </a>
            </li>
            <?php
          }else{
            ?>
            <li>
              <button class="button signUp">
                Sign up
              </button>
            </li>
            <li>
              <button class="button logIn">
                Log in
              </button>
            </li>
            <?php
          }

          ?>

        </ul>
      </div>
    </div>
    <div class="heroFooter">
      <a href="">Scroll down for more information</a>
    </div>
  </div>
</section>
