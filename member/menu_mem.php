<html>
<head>
	<title>Uckan.Net - Slide Drawer Menu</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>

      <header class="header">
        
        <div class="container">
          <div class="row">
            <div class="left menu-icon">
                <a href="#" id="hamburger-icon" title="Menu">
                  <span class="line line-1"></span>
                  <span class="line line-2"></span>
                  <span class="line line-3"></span>
                </a>
             </div>	
            <ul class="menu right" style="position: right;">
            

      <h2>
        <?php
            // ตรวจสอบว่า $_SESSION['member_status'] มีค่าหรือไม่
            if(isset($_SESSION['member_status'])){
                echo "" . $_SESSION['member_status'];
            } else {
                echo "ไม่พบข้อมูลสถานะ";
            }
            
        ?>
        <br>
        
          </h2>
        <h4>
        <?php
            // ตรวจสอบว่า $_SESSION['member_name'] มีค่าหรือไม่
            if(isset($_SESSION['member_name'])){
                echo "" . $_SESSION['member_name'];
            } else {
                echo "ไม่พบชื่อในระบบ";
            }
            ?>
        <?php
            if(isset($_SESSION['member_sername'])){
                echo "" . $_SESSION['member_sername'];
            } else {
                echo "ไม่พบชื่อในระบบ";
            }
        ?>
        
        
    </h4>


            </ul>
            
          </div>
        </div>
      </header>

      
  <!-- Slide Left Menu -->
  <div class="slide-menu">
    <div class="slide-header">
      <div class="slide-close-button">
        <button class="close"><i class="fa fa-close"></i></button>
      </div>
    </div>
    <div class="slide-menu-here">
      <ul class="menu">
      <li><a href="main_mem.php">Home</a></li>
        <li><a href="product_mem.php">Product</a></li>
        <li><a href="Member_mem.php">All User</a></li>
        <li><a href="report_mem.php">Balance report</a></li>
        <li><a href="scanbarcode.php">Scanbarcode</a></li>
        <li><a href="logout.php">Log out</a></li>

      </ul>
    </div>
  </div>
  
</body>
</html>  
<script>
$(document).ready(function(){
  
  //  Menu Add Class Left or Close 		
  $("#hamburger-icon, .slide-close-button button, .mdl-layout__obfuscator").click(function(){
    $(".slide-menu").toggleClass("slide-left");
  });

  // Menu Dropdown menu active
  $(".dropdownmenu").click(function(){
    $(".sub-menu").toggleClass("active").fadeIn(46000);
  });
});


</script>


<style>
html, body, div, span, applet, object, iframe, h1, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary, time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	vertical-align: baseline;
  font-family: Inter;
}
* {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}
.container {
  max-width: 1060px;
  margin: 0 auto
}
.content {
  max-width: 600px;
  line-height: 1.5;
  margin: 5em auto
}
.content p {
  margin: 1em 0
}
.btn {
  background-color: transparent;
  padding: 10px 15px;
  border: 1px solid #fff;
  border-radius: 3px
}
.btn>a {
  color: #fff
} 
.btn.hover-blue:Hover {
  background-color: #3F51B5
}
body {
	background: white;
	font-size: 14px;
	font-family: 'Roboto', serif;
	margin:0 auto;
    color: black;
	padding:0
}
li {
	list-style:none;
}
a {
	color: #333;
  text-decoration: none
  
}
h4{
  text-align: center;
  margin-top: 15%;
  
}
h2{
  text-align: center;
  margin-top: 15%;
  
  
}

ul.menu.right{
  text-align: center;
  position: fixed;
    margin-left: 70%;
}


.row {
  margin-left: 15px;
  margin-right: 15px
}
/* Starting */
.left {
  float:left
}
.right {
  float:right
}

#hamburger-icon {
  height: 20px;
  position: relative;
  display: block;
  margin-top: 1.200em;
  z-index: 9998;
  width: 50px

}

#hamburger-icon .line {
  display: block;
  background: #fff;
  width: 35px;
  height: 5px;
  position: absolute;
  left: 0;
  border-radius: 4px;
  transition: all 0.4s;
  -webkit-transition: all 0.4s;
  -moz-transition: all 0.4s;
}
#hamburger-icon .line.line-1 {
  top: 0;
}
#hamburger-icon .line.line-2 {
  top: 50%;
}
#hamburger-icon .line.line-3 {
  top: 100%;
}
#hamburger-icon.active .line-1 {
  transform: translateY(10px) translateX(0) rotate(45deg);
  -webkit-transform: translateY(10px) translateX(0) rotate(45deg);
  -moz-transform: translateY(10px) translateX(0) rotate(45deg)
}
#hamburger-icon.active .line-2 {
  opacity: 0;
}
#hamburger-icon.active .line-3 {
  transform: translateY(-10px) translateX(0) rotate(-45deg);
  -webkit-transform: translateY(-10px) translateX(0) rotate(-45deg);
  -moz-transform: translateY(-10px) translateX(0) rotate(-45deg)
}

.header {
  background: #3F51B5;
  width: 100%;
  height: 60px;
  box-shadow: 0 1px 4px #1A237E;
  line-height: 6px;
  color: #fff
}
.header a {
  color: #fff
}
.header ul.menu>li {
  float:left;
  position: relative;
  line-height: 60px;
  padding: 0 1em
}
.header ul.menu>li:before {
  position: absolute;
  width: 100%;
  height: 2px;
  background-color: #fff;
  transition: all .3ms;
  bottom: 0;
  left:0;
  content: '';
  display: none
}
.header ul.menu>li:hover:before {
  display: block
}
.header ul.menu>li.text:after {
  position: absolute;
  content: '';
  background-color: #fff;
  width: 2px;
  height: 2px;
  right: 0;
  top: 29px
}
/* Slide Menu */
.slide-menu {
  position: fixed;
    -webkit-transform: translateX(-285px);
    -ms-transform: translateX(-285px);
    transform: translateX(-285px);
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
    will-change: transform;
    -webkit-transition-duration: .2s;
    transition-duration: .2s;
    -webkit-transition-timing-function: cubic-bezier(.4,0,.2,1);
    transition-timing-function: cubic-bezier(.4,0,.2,1);
    -webkit-transition-property: -webkit-transform;
    transition-property: transform;
  background: #fff;
  top:0;
  bottom: 0;
  color: #333;
  z-index: 9999;
  width: 250px;
    -webkit-box-shadow: 3px 0px 7px 0px rgba(0,0,0,0.25);
    -moz-box-shadow: 3px 0px 7px 0px rgba(0,0,0,0.25);
    box-shadow: 3px 0px 7px 0px rgba(0,0,0,0.25);
}
.slide-header {
  height: 150px;
  color: #fff;
  top:0;
  background: url(https://media.discordapp.net/attachments/773568429793083412/1197905355909378108/P_2.png?ex=65bcf74c&is=65aa824c&hm=7d135e66e43b97ebf9dab9a57d8ebe72ed039c38b0cd992783233131f29f6110&=&format=webp&quality=lossless)no-repeat center center/cover;
  position: relative;
  text-align: center;
}
.slide-close-button button:hover{
  background-color: #a1a1a1
}
.slide-close-button button:active {
  background-color: #bbb
}
.slide-close-button button {
  background: #aaa;
  border: 0;
  font-size: 16px;
  border-radius: 50%;
  width: 35px;
  height: 35px;
  text-align: center;
  color: #fff;
  cursor: pointer;
  position: absolute;
  bottom: -15px;
  outline: none;
  right: 2em;
  z-index: 99999;
}
.slide-header>h1 {
  padding: 2em 0 0
}
.slide-header p {
  font-size: 12px
}
.slide-menu>.slide-menu-here>.menu {
  padding: .5em 0;
}
.slide-menu>.slide-menu-here>.menu li {
  position: relative
}
.slide-menu>.slide-menu-here>.menu li>a{
  padding: .8em 1em;
  width: 100%;
  position: relative;
  border-bottom: 1px solid #ececec;
  display: inline-block
  
}
.slide-menu>.slide-menu-here>.menu li.title span {
  padding: .8em 1em;
  border-bottom: 1px solid #ececec;
  width: 100%;
  position: relative;
  display: inline-block;
}
.slide-menu>.slide-menu-here>.menu li>.sub-menu {
    -webkit-transform: translateY(-100px);
    -ms-transform: translateY(-100px);
    transform: translateY(-100px);
    -webkit-transform-style: preserve-3d;
    transform-style: preserve-3d;
    will-change: transform;
    -webkit-transition-duration: .65s;
    transition-duration: .65s;
    -webkit-transition-timing-function: cubic-bezier(.4,0,.2,1);
    transition-timing-function: cubic-bezier(.4,0,.2,1);
    -webkit-transition-property: -webkit-transform;
    transition-property: transform;
    display:none
}
.slide-menu>.slide-menu-here>.menu li>.sub-menu.active {
  display: block;
    -webkit-transform: translateY(0px);
    -ms-transform: translateY(0px);
    transform: translateY(0px);
}
.slide-menu>.slide-menu-here>.menu li>.sub-menu>li>a {
  padding-left: 2em;
  font-size: 13px;
  border-bottom: 1px solid #f5f5f5
}
.slide-menu>.slide-menu-here>.menu li.title>.dropdownmenu:after {
  content: "\f107";
  top: 10px;
  position: Absolute;
  right: 2em;
  background-color: #aaa;
  width: 20px;
  height: 20px;
  text-align: center;
  cursor: pointer;
  border-radius: 50%;
  line-height: 20px;
  color: #fff;
  font: normal normal normal 14px/20px FontAwesome;
}
.slide-menu a:hover {
  background-color: #f8f8f8
}
/* Slide Left  */
.slide-left {
      -webkit-transform: translateX(0);
    -ms-transform: translateX(0);
    transform: translateX(0);
    z-index: 99999;
}
.mdl-layout__obfuscator {
    background-color: transparent;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    visibility: hidden;
    -webkit-transition-property: background-color;
    transition-property: background-color;
    -webkit-transition-duration: .2s;
    transition-duration: .2s;
    -webkit-transition-timing-function: cubic-bezier(.4,0,.2,1);
    transition-timing-function: cubic-bezier(.4,0,.2,1);
}
.slide-left~.mdl-layout__obfuscator {
    background-color: rgba(0,0,0,.5);
    visibility: visible;
}
</style>