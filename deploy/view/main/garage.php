<section class="garage">

  <div class="garageProfileHeader">
    <div class="gradient"></div>
    <div class="container">
      <ul class="profile-header-list">
        <li class="avatar">
          <div class="avatar-container">
            <img src="https://scontent-fra3-1.xx.fbcdn.net/v/t1.0-9/13310379_10201831517505192_8113941914163471612_n.jpg?oh=32091fbd5b740fb77295eddf8dab0587&oe=59386128" />
          </div>
        </li>
      </ul>
      <div class="profile-title">
        <h1><?php echo $_SESSION['user']['username'] ?></h1>
        <p>
          CR: <span class="playerCredits"><?php echo $playerData['credits']; ?></span>
        </p>
      </div>
    </div>
    <!--<div class="profileImage">
      <div class="imageContainer">
        <div class="imageContent" style="background-image:url('https://scontent-fra3-1.xx.fbcdn.net/v/t1.0-9/13310379_10201831517505192_8113941914163471612_n.jpg?oh=32091fbd5b740fb77295eddf8dab0587&oe=59386128')">

        </div>
      </div>
    </div>
    <div class="profileContent">

      <header class="title">
        <h1>Your stats</h1>
        <div class="title-line"></div>
      </header>

      <p>
        CR: <span class="playerCredits"><?php echo $playerData['credits']; ?></span>
      </p>

    </div>-->
  </div>

  <div class="garageContainer">
    <div class="half sides">
      <header class="title">
        <h1>Your garage</h1>
        <div class="title-line"></div>
      </header>

      <div class="garageLoader">

        <div class="loaderNotification">
          <img src="assets/images/gears.svg">
          <p>Loading your garage... One moment please</p>
        </div>

        <script id="garage-car" type="text/x-handlebars-template">
          <li>
            <div class="garageListItem">
              <div class="garageListItemImage ">

                <div class="garageListItemCarTitle"><p>{{car_name}}</p></div>
                <div class="garageCarContainer animated bounceInLeft">
                  <div class="wheel front"><img src="assets/wheels/wheel.png"></div>
                  <div class="wheel back"><img src="assets/wheels/wheel.png"></div>
                  <div class="garageListItemImageHolder" style="background-image:url('{{car_file}}')"><img src=""></div>
                </div>

              </div>
              <div class="garageListItemActions">
                <div class="garageListActionsHolder">
                  <ul class="garageActions">
                    <li><a href="">Modify car</a></li>
                    {{#if onacruise}}
                      <li><a href="garage/return-from-cruise/{{car_id_md5}}">Return home</a></li>
                    {{else}}
                      <li><a href="garage/go-on-cruise/{{car_id_md5}}">Go on a cruise</a></li>
                    {{/if}}
                    <li><a href="">Sell car</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </li>
        </script>

        <ul class="garageList"></ul>
      </div>
    </div>
    <div class="half sides">
      <header class="title">
        <h1>Your inventory</h1>
        <div class="title-line"></div>
      </header>

      <div class="inventoryLoader">

        <div class="loaderNotification">
          <img src="assets/images/gears.svg">
          <p>Loading your inventory... One moment please</p>
        </div>

        <script id="garage-inventory" type="text/x-handlebars-template">
          <li class="inventoryListChild">
            <div class="inventoryListItem animated bounceInLeft">
              <div class="inventoryListItemContainer">
                <div class="inventoryContent">
                  <h1>{{part_name}}</h1>
                  <button class="salvage-part" data-id="{{part_id}}" data-inventory-id="{{inventory_id}}">Salvage part</button>
                </div>
                <div class="inventoryListItemImage ">
                  <div class="imageContainer">
                    <div class="imageContent" style="background-image:url('{{part_file}}')"></div>
                  </div>
                </div>
              </div>
              <!--

              -->

            </div>
          </li>
        </script>

        <ul class="inventoryList"></ul>
      </div>

    </div>
  </div>
</section>
