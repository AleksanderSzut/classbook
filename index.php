<?php
	session_start();

	require_once "function.php";
	if((!isset($_SESSION['online'])) && ($_SESSION['online'] == false))
	{
		header('Location:home');session_unset();exit();
	}
	elseif($_SESSION['activated'] == 0)
	{
		header('Location:activate.php?id='.$_SESSION['id']);$_SESSION['activate_online'] = true;exit();
	}
?>
    <!DOCTYPE html>
    <html lang="pl">

    <head>
        <meta charset="utf-8" />
        <title>Classbook-strona główna</title>
        <link rel="shortcut icon" href="style/img/logo.gif" />
        <link rel="stylesheet" href="style/style.css" type="text/css" />
        <link rel="stylesheet" href="css/fontello.css" type="text/css" />
        <link href='https://fonts.googleapis.com/css?family=Lato:400,300' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <script src="jquery/jquery.scrollTo.min.js"></script>
        <script src="function.js"></script>
    </head>

    <body background="style/img/jpg.jpg" <?php OnloadBodyJs(0);?>>
        <a href="#" class="scroll_up_click">
            <div class="scrollup"><i class="icon-angle-up"></i></div>
        </a>
        <div id="div_info"></div>
        <div id="conteiner">
            <?php

			view_nav();
			view_search();

			?>
            <div class="mid_div">
                <div class="content">
                    <div class="new_post" id="add_post">
                        <form method="post" action="javascript:add_post(1);">
                            <div class="top_new_post">
                                <div class="type_new_post" onclick="add_post_type(1,0)"><i class="icon-quote-right"></i></div>
                                <div class="type_new_post" onclick="add_post_type(2,0)"><i class="icon-camera"></i></div>
                                <div class="type_new_post" onclick="add_post_type(3,0)"><i class="icon-video"></i></div>
                            </div>
                            <textarea class="new_post_input" placeholder="Co tam?" rows="auto" id="post"></textarea>
                            <div class="bottom_new_post">
                                <div class="type_new_post2"><i class="icon-tag"></i>
                                    <div class="menu_sliding">
                                        <div class="menu_sliding_justdoit">
                                            Już wkrótce
                                        </div>
                                    </div>
                                </div>
                                <div class="type_new_post2"><i class="icon-eye"></i>
                                    <div class="menu_sliding">
                                        <form>
                                            <div class="options_new_post_view">
                                                <input type="radio" name="view" value="1" id="checkbox_newpost" class="checkbox_newpost">
                                                <label for="checkbox_newpost" class="new_post_options_label">Znajomi</label>
                                            </div>
                                            <div class="options_new_post_view">
                                                <input type="radio" name="view" value="2" id="checkbox_newpost2" class="checkbox_newpost">
                                                <label for="checkbox_newpost2" class="new_post_options_label">Tylko ja!</label>
                                            </div>
                                            <div class="options_new_post_view">
                                                <input type="radio" name="view" value="3" id="checkbox_newpost3" class="checkbox_newpost">
                                                <label for="checkbox_newpost3" class="new_post_options_label">Publiczne</label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="type_new_post2"><i class="icon-location"></i>
                                    <div class="menu_sliding">
                                        <div class="menu_sliding_justdoit">
                                            Już wkrótce
                                        </div>
                                    </div>
                                </div>
                                <input value="Dodaj post" class="new_post_buttom" type="submit">
                            </div>
                        </form>
                    </div>
                    <?php
                        require_once "function.php";
                        
                        view_boxPost();
                    
                    ?>
                </div>
                <div class="content_chat">
                    <div class="window_chat"></div>
                    <div class="window_chat"></div>
                    <div class="window_chat"></div>
                </div>
            </div>
            <?php
                
                require_once "function.php";
                
                view_rightDiv();
                
            ?>
        </div>
        
    </body>
</html>

