/*global*/
var type_viewPost;

function size_screen()
{
    if(screen.heigh < 1080 || screen.width <1920)
    {
        alert("twoja rozdzielczość może być za mała radzimy pomniejszyć stronę");
    }
}

function like(type, id_post, num_like) 
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
        	if(type == 1)
            {
    			$("#id_"+id_post+"_dont").addClass("post_like");
				$("#id_"+id_post+"_dont").removeClass("post_like_active");
				document.getElementById("num_like_"+id_post).innerHTML = xmlhttp.responseText;
    			$("#id_"+id_post).addClass("post_like_active");
    			$("#id_"+id_post).removeClass("post_like");
        	}
        	else
        	{

        		$("#id_"+id_post).addClass("post_like");
				$("#id_"+id_post).removeClass("post_like_active");
				document.getElementById("num_like_dont_"+id_post).innerHTML = xmlhttp.responseText;
        		$("#id_"+id_post+"_dont").addClass("post_like_active");
				$("#id_"+id_post+"_dont").removeClass("post_like");
        	}
        }
    }
    xmlhttp.open("GET", "ajax_like.php?id_post=" + id_post + "&& type=" + type, true);
    xmlhttp.send();
}

function menuExpand(objectName)
{
    document.getElementById(objectName).style.transform = "display:block";
}

function online()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {

    }
    xmlhttp.open("GET", "ajax_online.php", true);
    xmlhttp.send();
    setTimeout("online()",10000);
}

function friends()
{
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
        	document.getElementById("friends").innerHTML = xmlhttp.responseText;
    	}
    }
    xmlhttp.open("GET", "ajax_friends.php", true);
    xmlhttp.send();
    setTimeout("friends()",60000);
}

function add_friends(id_user)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            var zwrocona = xmlhttp.responseText;
            
            if(zwrocona != 0)
                document.getElementById("add_user").innerHTML = zwrocona;

            friends()           
        }
    }
    xmlhttp.open("GET", "ajax_add_friends.php?id_user=" + id_user, true);
    xmlhttp.send();
}

function accepting_knowledge(type, id_user)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            friends();
            view_news()
            console.log(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET", "ajax_accepting_knowledge.php?id_user=" + id_user + " && type=" + type, true);
    xmlhttp.send();
}

function view_news()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            var text = xmlhttp.responseText;
            if(text.length == 0)
                text = "Nie masz żadnych wiadomości.";
            document.getElementById("view_news").innerHTML = text;
        
        }
    }
    xmlhttp.open("GET", "ajax_view_news.php", true);
    xmlhttp.send();
}

function amount_of_news()
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            var text = xmlhttp.responseText;
            document.getElementById("number_news").innerHTML = text;
            if(text!=0)
               document.getElementById("number_news").style.display="block";
           else
               document.getElementById("number_news").style.display="none";

        }
    }
    xmlhttp.open("GET", "ajax_view_amount_of_notifications.php?type=1", true);
    xmlhttp.send();
    setTimeout("amount_of_news()",1000);
}

function open_news()
{
    document.getElementById('number_news').style.display='block';
}

function view_info()
{
    document.getElementById("div_info").innerHTML = "";
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            if(xmlhttp.responseText.length > 0)document.getElementById("div_info").innerHTML = xmlhttp.responseText;
            else setTimeout("view_info()",4000);
        }
        
    }


    xmlhttp.open("GET", "ajax_view_info.php", true);
    xmlhttp.send();
}

jQuery(function($)
{
    //zresetuj scrolla
    $.scrollTo(0);
            
    $('.scroll_up_click').click(function() { $.scrollTo($('body'), 3000); });
}
);

$(window).scroll(function()
{
    if($(this).scrollTop()>300) $('.scrollup').fadeIn();
    else $('.scrollup').fadeOut();      
}
);

function add_post(type)
{
    if(document.getElementById('checkbox_newpost').checked)var wartosc = document.getElementById('checkbox_newpost').value;
    else if(document.getElementById('checkbox_newpost2').checked)var wartosc = document.getElementById('checkbox_newpost2').value;
    else if(document.getElementById('checkbox_newpost3').checked)var wartosc = document.getElementById('checkbox_newpost3').value;
    var post = document.getElementById('post').value;
    document.getElementById('post').value = "";

        

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
            if(xmlhttp.responseText == 0)
            {
                document.getElementById("div_info").innerHTML = xmlhttp.responseText;
                
                view_post(type_viewPost);
                
            }
            else
            {
                document.getElementById("div_info").innerHTML = xmlhttp.responseText;
                
                view_post(type_viewPost);
                
            }

        }
    }
    xmlhttp.open("GET", "ajax_add_post.php?post=" + post + "&& view=" + wartosc, true);
    xmlhttp.send();
    setTimeout("add_post()", 60000);

}

function add_post_type(type,type_file)
{
    switch(type) 
    {
        case 1:    
            document.getElementById("add_post").innerHTML = '<form method="post"  action="javascript:add_post('+type_file+');"><div class="top_new_post"><div class="type_new_post" onclick="add_post_type(1,'+type_file+')"><i class="icon-quote-right" ></i></div><div class="type_new_post" onclick="add_post_type(2,'+type_file+')"><i class="icon-camera"></i></div><div class="type_new_post" onclick="add_post_type(3,'+type_file+')"><i class="icon-video"></i></div></div><textarea class="new_post_input" placeholder="Co tam?" rows="auto" id="post"></textarea><div class="bottom_new_post"><div class="type_new_post2"><i class="icon-tag"></i><div class="menu_sliding"><div class="menu_sliding_justdoit">Już wkrótce</div></div></div><div class="type_new_post2"><i class="icon-eye"></i><div class="menu_sliding"><form><div class="options_new_post_view"><input type="radio" name="view" value="1" id="checkbox_newpost" class="checkbox_newpost"><label for="checkbox_newpost" class="new_post_options_label">Znajomi</label></div><div class="options_new_post_view"><input type="radio" name="view" value="2" id="checkbox_newpost2" class="checkbox_newpost"><label for="checkbox_newpost2" class="new_post_options_label">Tylko ja!</label></div><div class="options_new_post_view"><input type="radio" name="view" value="3" id="checkbox_newpost3" class="checkbox_newpost"><label for="checkbox_newpost3" class="new_post_options_label">Publiczne</label></div></form></div></div><div class="type_new_post2"><i class="icon-location"></i><div class="menu_sliding"><div class="menu_sliding_justdoit">Już wkrótce</div></div></div><input value="Dodaj post" class="new_post_buttom" type="submit"></div></form>';
        
        break;
        case 2:
            document.getElementById("add_post").innerHTML = '<form method="post" action="javascript:add_post_file('+type_file+');"><div class="top_new_post"><div class="type_new_post" onclick="add_post_type(1,'+type_file+')"><i class="icon-quote-right"></i></div><div class="type_new_post" onclick="add_post_type(2,'+type_file+')"><i class="icon-camera"></i></div><div class="type_new_post" onclick="add_post_type(3,'+type_file+')"><i class="icon-video"></i></div></div><textarea class="new_post_input_2" placeholder="Co tam?" rows="auto" id="post"></textarea><div class="upload_img_post"><input type="file" onchange="view_img()" id="inp_post_img" style="display:none"/><label for="inp_post_img"><div class="add_img_post_buttom">Dodaj zdjęcie</div></label><div id="upload_img_add_post"></div></div><div class="bottom_new_post"><div class="type_new_post2"><i class="icon-tag"></i><div class="menu_sliding"><div class="menu_sliding_justdoit">Już wkrótce</div></div></div><div class="type_new_post2"><i class="icon-eye"></i><div class="menu_sliding"><form><div class="options_new_post_view"><input type="radio" name="view" value="1" id="checkbox_newpost" class="checkbox_newpost"><label for="checkbox_newpost" class="new_post_options_label">Znajomi</label></div><div class="options_new_post_view"><input type="radio" name="view" value="2" id="checkbox_newpost2" class="checkbox_newpost"><label for="checkbox_newpost2" class="new_post_options_label">Tylko ja!</label></div><div class="options_new_post_view"><input type="radio" name="view" value="3" id="checkbox_newpost3" class="checkbox_newpost"><label for="checkbox_newpost3" class="new_post_options_label">Publiczne</label></div></form></div></div><div class="type_new_post2"><i class="icon-location"></i><div class="menu_sliding"><div class="menu_sliding_justdoit">Już wkrótce</div></div></div><input value="Dodaj post" class="new_post_buttom" type="submit"></div></form>';
        
        break;
        case 3:
            document.getElementById("add_post").innerHTML = "lol23";
        
    }
}

function add_post_file(type)
{
    if(document.getElementById('checkbox_newpost').checked)var wartosc = document.getElementById('checkbox_newpost').value;
    else if(document.getElementById('checkbox_newpost2').checked)var wartosc = document.getElementById('checkbox_newpost2').value;
    else if(document.getElementById('checkbox_newpost3').checked)var wartosc = document.getElementById('checkbox_newpost3').value;
    var post = document.getElementById('post').value;
    document.getElementById('post').value = "";

    if(file = document.getElementById("inp_post_img").files[0])
    {
        var formularz = new FormData(); //tworzymy nowy formularz do wysłania
        formularz.append("file", file); //dodajemy do formularza pole z naszym plikiem
        formularz.append("post", post); //dodajemy do formularza pole z naszym plikiem
        formularz.append("view", wartosc); //dodajemy do formularza pole z naszym plikiem

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function()
        {
            if (xhr.readyState == 4 && xhr.status == 200)
            {
                document.getElementById("div_info").innerHTML = xhr.responseText;

                view_post(type_viewPost);

            }
            else
            {
                document.getElementById("div_info").innerHTML =xhr.responseText;

                view_post(type_viewPost);

            }
        }
        xhr.open("POST", "ajax_add_post_img.php", true);
        xhr.send(formularz);
    }
    else
    {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
            {
                if(xmlhttp.responseText == 0)
                {
                    document.getElementById("div_info").innerHTML = xmlhttp.responseText;
                    if(type == 2)
                    {
                        view_post(type);
                    }
                }
                else
                {
                    document.getElementById("div_info").innerHTML = xmlhttp.responseText;
                    if(type == 2)
                    {
                        view_post(type);
                    }
                }

            }
        }
        xmlhttp.open("GET", "ajax_add_post.php?post=" + post + "&& view=" + wartosc, true);
        xmlhttp.send();
    }

}

function preview_uploadImg(formId)
{

    console.log("startPrev");
    const $div = $('.previewImgWrapper');
    $div.html('Ładowanie');

    if(file = document.getElementById(formId).files[0])
    {
        var form = new FormData();
        form.append("file", file);

        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function()
        {
            if (xhr.readyState == 4 && xhr.status == 200)
            {
                console.log("start");
                var result = xhr.responseText;
                var lengthResult = result.length;

                var contentResult = result.slice(3, lengthResult);
                var errorResult = result.slice(0, 1);

                console.log(errorResult);

                if(errorResult == 1)
                {
                    console.log(result);
                    $div.html('<img style="" src="'+contentResult+'"/>');
                }
                else
                {
                    $div.html(contentResult);
                }

            }
            else
            {
                console.log("błąd");
            }
        }
        xhr.open("POST", "ajax_uploadImg.php", true);
        xhr.send(form);


    }
    else
    {
        console.log("nie");

    }
}

function search()
{
    var q = document.getElementById("q").value;

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("result_ajax_search").innerHTML = xmlhttp.responseText;

        }
    }
    xmlhttp.open("GET", "ajax_search.php?q=" + q, true);
    xmlhttp.send();

}

function view_search_div(type)
{
    if(type != 1)
    {
        $('.search_result_div').fadeOut();
    }
    else
    {
        $('.search_result_div').fadeIn();

    }
}

function add_profile()
{
    var file=document.getElementById("file").files[0];

    var formularz=new FormData(); //tworzymy nowy formularz do wysłania
    formularz.append("file", file); //dodajemy do formularza pole z naszym plikiem

    /* wysyłamy formularz za pomocą AJAX */
    var xhr=new XMLHttpRequest();
    xhr.upload.addEventListener("progress", progress, false);
    xhr.addEventListener("load", end, false);
    xhr.addEventListener("error", error, false);
    xhr.addEventListener("abort", stop, false);
    xhr.open("POST", "./ajax_upload_profile.php", true);
}

function delete_post(id_post)
{
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("div_info").innerHTML = xmlhttp.responseText;
            view_post(2);
        }
    }
    xmlhttp.open("GET", "ajax_delete_post.php?id_post="+id_post, true);
    xmlhttp.send();
}

function view_post(type)
{
    type_viewPost = type;
    var formularz = new FormData(); //tworzymy nowy formularz do wysłania
    formularz.append("type", type); //dodajemy do formularza pole z naszym plikiem

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            document.getElementById("view_post").innerHTML = xhr.responseText;

        }
    }
    xhr.open("POST", "ajax_view_post.php", true);
    xhr.send(formularz);


}

function view_tables_group()
{
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            document.getElementById("view_tabele_group").innerHTML = xhr.responseText;

        }
    }
    xhr.open("POST", "ajax_view_tabele_group.php", true);
    xhr.send();
}

function join_group(idG)
{

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function()
    {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            document.getElementById("div_info").innerHTML = xhr.responseText;

        }
    }
    xhr.open("POST", "ajax_join_group.php?idG="+idG, true);
    xhr.send();
}
