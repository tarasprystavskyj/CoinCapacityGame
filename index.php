<!DOCTYPE HTML>
<html lang="en">
    <?php
    session_start();
    ?>

    <!-- ****** -->
    <!-- HEADER -->
    <!-- ****** -->
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Coin Collection Game">
        <title>Coin Collector Game</title>

        <script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
        <script type="text/javascript" src="js/classes.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>

        <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet"/>
        <link type="text/css" href="css/jquery-ui-1.10.3.custom.css" rel="stylesheet">
        <link type="text/css" href="css/main.css" rel="stylesheet"/>

        <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
        <link rel="icon" href="images/favicon.ico" type="image/x-icon">

<!--	<script type="text/javascript" src="js/simple-slider.min.js"></script>-->
        <!--	<link type="text/css" href="css/simple-slider.css" rel="stylesheet"/>-->


    </head>

    <!-- **** -->
    <!-- BODY -->
    <!-- **** -->
    <body>
        <h1>The Coin Collecting Game</h1>

        <!-- landing / login page -->
        <div id="landing">
            <p>To play the coin collecting game, you'll need a participation code.  You should have received a link which included the code which would have looked like this:</p>
            <p>http://ccg.samswift.org/?userID=glIqFtKsIN</p>

            <p>You are currently visiting the game without a participation code or with one that we do not recognize.  Please e-mail adrian.camilleri@uts.edu.au if you think there is a problem.</p> 
            <input type="hidden" id="user" class="user" value="<?php
            if (isset($_GET['userID'])) {
                echo($_GET['userID']);
            }
            ?>">	
            <!--<button id='btn-login'>Login</button> -->
        </div>

        <!-- game intro page -->
        <div id="intro">
            <div><img src="images/rounds.png">The coin collection game will last <span class="total_rounds"></span> rounds.</div>
            <div><img src="images/coin.png" width="30" height="30">At the beginning of each round between 0 and 10 coins will appear.</div>
            <div><img src="images/piggy.png" width="40" height="35">You have a bank account with an initial balance of 50 coins.  During each round, you can add to that balance by collecting coins.  Your goal is to have as many coins as you can in your bank account at the end of the game.</div>
            <div><img src="images/slot.png" width="45" height="20">To collect coins you will need a coin collector tool.</div>
            <div>
                <img src="images/selector.png" width="248" height="128">
                <p>The collector tool can vary in size from one that can collect 1 coin per round up to one that can collect 10 coins per round.</p>
                <p>Collectors that have the capacity to collect more coins are more expensive to purchase. You will buy collectors using coins from your bank balance.</p>
                <p>After every <span class='rounds'></span> rounds of play your collector tool will wear out and you will be required to purchase a new collector.</p>
            </div>

            <div class="intro_show_rent">
                <button type="button" style="pointer-events: none; font-size: 1rem; ">Rent Capacity for 4 Coins</button>
                <div>
                    If you fail to collect coins on a particular round, you will be given the option to rent another collector just for that round, which will allow you to collect all the available coins.
                </div>
            </div>

            <div>Each coin that you collect will add 1 coin to your balance. Each coin that you do not collect will not change your balance.</div>
            <div>At the end of the game the number of coins that you have collected will be converted into real money at the rate of 1 coin = 1 cent, which you will receive as a bonus payment.</div>

            <br class="clearfix">
            <br>		
            <p>Good Luck!</p>
            <h2>Are you ready to begin?</h2>
            <button id='btn-begin'>Begin</button>
        </div>


        <!-- coin totals -->
        <div id="coin_tots">
            <div id="this_round">
                <b>Round <span id="curr_round"></span> of <span class="total_rounds"></span></b>
                <div id="rcp">
                    <span class="stat" id='coins_poss_this'></span>coins possible
                </div>
                <div id="rcc">
                    <span class="stat" id='coins_coll_this'></span>coins collected
                </div>
                <div id="rcnc">
                    <span class="stat" id='coins_lost_this'></span>coins not collected
                </div>			
            </div>
            <div id="all_rounds">
                <b>Overall</b>
                <div id="tcp" ><span class="stat" id='coins_poss_tot'></span>total coins possible</div>
                <div id="tcc" ><span class="stat" id='coins_coll_tot'></span>total coins collected</div>
                <div id="tcl" ><span class="stat" id='coins_lost_tot'></span>total coins lost</div>
                <div id="cs"  ><span class="stat" id='coins_spent_tot'></span>coins spent</div>
                <div id="bank"><span class="stat" id='coins_bank_tot'></span>coins in bank</div>
            </div>
            <div id="buttons">
                <button id='btn-buy'>Buy collector</button><br />			
                <button id='btn-bank'>Deposit Coins</button><br />	
                <button id='btn-next'>Next Round</button><br />
            </div>	   

            <div class="clearfix"></div>
        </div>


        <!-- collector size select -->
        <div id="select_collect">
            Please choose a coin collector from the choices below. 
            Larger collectors cost more and can collect more coins per round.
            The collector you choose now will last only <span class='rounds'></span> rounds after which you will have to choose again. 
            <table class="collectors" id="buy_collectors"> <!-- contents dynamic & populated via javascript -->
            </table>
        </div>


        <!-- next round -->
        <div align="center"></div>


        <!-- round start / coins appear -->
        <div id="round_start">
            <table align='right' id="coin_drop"> 
                <tr>
                    <td id="coins_lost"></td>
                    <td id="coins_coll"></td>
                    <td id="coins_move"></td>
                </tr>
                <tr>

                    <td class="text-right">
                        <button type="button" id="btn-rent">Rent Capacity
                    </td>
                    <td></td>
                    <td id='piggy'></td>

                </tr>
                <tr>
                    <td></td><td></td><td></td>
                </tr>
            </table>
            <br><br>

            <table class="collectors" id="bought_collectors"> <!-- contents dynamic & populated via javascript -->
            </table>
        </div>


        <!-- post block survey -->
        <div id="postblocksurvey">
            <p>How many coins appeared each round, on average, over the last <span class='rounds'></span> rounds?</p>
            <div id="pbs-1"></div>
            <div class="clearfix"></div>
            <p>How many coins appeared each round, on average, since the beginning of the game?</p>
            <div id="pbs-2"></div>
            <button id='btn-pbs'>Continue</button>
        </div>


        <!-- post game survey -->
        <div id="postgamesurvey">
            <p>How many times was your collector too small for the coins that appeared?</p>
            <div id="pgs-1"></div>
            <div class="clearfix"></div>
            <p>If you had to play again now and pick one collector for all rounds, what size would you pick?</p>
            <div id="pgs-2"></div>
            <button id='btn-pgs'>Finish</button>
        </div>


        <!-- admin options -->
        <div id="admin">
            Optional administrator functions
        </div>


        <!-- credits -->
        <div id="credits">
            <p>Thank you for participating in the study.</p>

        <form class="text-center">
            <input type="button" id ="finish_button" value="Continue"/>
        </form>
    </div>
</body>
</html>