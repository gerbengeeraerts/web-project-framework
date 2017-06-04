<section class="market">
  <div class="marketContainer">

    <header class="title">
      <h1>Recently added items</h1>
      <div class="title-line"></div>
    </header>

    <ul class="market-list">
      <?php
        foreach($marketItems as $marketItem){
          ?>
          <li>
            <p>
              <?php echo $marketItem['seller']['username']; ?>
            </p>
            <p>
              <?php echo $marketItem['itemData']['title']; ?>
            </p>
          </li>
          <?php
        }
       ?>
    </ul>

  </div>
</section>
