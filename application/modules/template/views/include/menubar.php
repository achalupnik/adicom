 <style>
 
 #wrapper {
    padding-left: 0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
    overflow: hidden;
}
 
#wrapper.toggled {
    padding-left: 250px;
    overflow: scroll;
}
 
#sidebar-wrapper {
    overflow-x: hidden; 
    z-index: 1000;
    position: fixed; 
    left: 250px;
    width: 0;
    height: 100%;
    margin-left: -250px;
    overflow-y: auto;
    background: #F8F8F8;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

#wrapper.toggled #sidebar-wrapper {
    width: 250px;
}
 
#page-content-wrapper {
    position: absolute;
    padding: 15px;
    width: 100%;  
    overflow-x: hidden; 
}
.xyz{
    min-width: 360px;
}
#wrapper.toggled #page-content-wrapper {
    position: relative;
    margin-right: 0px; 
}
.fixed-brand{
    width: auto;
}
/* Sidebar Styles */
 
.sidebar-nav {
    position: absolute;
    top: 0;
    width: 250px;
    margin: 0;
    padding: 0;
    list-style: none;
    margin-top: 2px;
}
 
.sidebar-nav li {
    text-indent: 10px;
    line-height: 40px;
    border-radius: 5px;
    overflow: hidden;
}
 
.sidebar-nav li a {
    display: block;
    text-decoration: none;
    color: #337AB7;
    margin-left: 2px;
    overflow: hidden;
    white-space: nowrap; 
    text-overflow: ellipsis; 
}

.sidebar-nav li a span {
    margin-left: -7px;
}
 
.sidebar-nav li a:hover {
    text-decoration: none;
    color: white;
    background: lightskyblue;
    border-left: #8D3895 2px solid;
    margin-left: 0px;   
}
 
.sidebar-nav li a:active,
.sidebar-nav li a:focus {
    text-decoration: none;
}
 
.sidebar-nav > .sidebar-brand {
    height: 65px;
    font-size: 18px;
    line-height: 60px;
}
 
.sidebar-nav > .sidebar-brand a {
    color: #337AB7;
}
 
.sidebar-nav > .sidebar-brand a:hover {
    color: #fff;
    background: none;
}
.no-margin{
    margin:0;
}
 
    #wrapper {
        padding-left: 250px;
    }
    .fixed-brand{
        width: 250px;
    }
    #wrapper.toggled {
        padding-left: 0;
    }
 
    #sidebar-wrapper {
        width: 250px;
    }
 
    #wrapper.toggled #sidebar-wrapper {
        width: 250px;
    }
    #wrapper.toggled-2 #sidebar-wrapper {
        width: 50px;
    }
    #wrapper.toggled-2 #sidebar-wrapper:hover {
        width: 250px;
    }
 
 
    #page-content-wrapper {
        padding: 0px;
        position: relative;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
    }
 
    #wrapper.toggled #page-content-wrapper {
        position: relative;
        margin-right: 0;
        padding-left: 250px;
    }
    #wrapper.toggled-2 #page-content-wrapper {
        position: relative;
        margin-right: 0;
        margin-left: -200px;
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
        width: auto;

    }

#sidebar-wrapper .sidebar-nav li.active a {
    background-color: lightblue;
    color: white;
}

#sidebar-wrapper .sidebar-nav li.active ul 
{
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
    display:block !important;
    background-color: #E1D4E4;
    margin-left: 3px;
    border-radius: 4px;
    padding-left: 10px;
}
#sidebar-wrapper:hover .sidebar-nav li.active ul { 
        -webkit-transition: all 0.5s ease;
        -moz-transition: all 0.5s ease;
        -o-transition: all 0.5s ease;
        transition: all 0.5s ease;
        padding-left: 40px;
    }

#wrapper.toggled-2  #sidebar-wrapper:hover ~ #page-content-wrapper { 
    opacity: .1; filter: alpha(opacity=50);
}

.scrollbar
{
    margin-left: 30px;
    float: left;
    height: 300px;
    width: 65px;
    background: #F5F5F5;
    overflow-y: scroll;
    margin-bottom: 25px;
}

#sidebar-wrapper::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);
    background-color: #F5F5F5;
    border-radius: 4px;
}

#sidebar-wrapper::-webkit-scrollbar
{
    width: 4px;
    background-color: #F5F5F5;
}

#sidebar-wrapper::-webkit-scrollbar-thumb
{
    border-radius: 4px;
    background-color: #337AB7;
}



@media print {
    #wrapper {
        padding-left: 200px;
    }
    #page-content-wrapper {
        margin-left: -250px;
        width: 100%;
    }
}


</style>
 
 
 <!-- Navigation -->
    <div id="wrapper" class="toggled-2">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="hidden-print">
            <ul class="sidebar-nav nav-pills nav-stacked" id="menu">
            <?php 
                if(is_numeric($this->session->userdata('user_id'))) {
                    $active_module=$this->router->fetch_class();
                    foreach($menu_items as $item) {
                        if($active_module==$item['name']) {
                            $li_class="active";
                        } else {
                            $li_class='';
                        }
                        echo '<li';
                        if($li_class != '') echo ' class="'.$li_class.'" ';
                        echo '>';

                        echo '<a';
                        if($active_module==$item['name'])echo " class='active'";
                        if($item['auxiliary'] == 0) {
                            echo " href='".base_url().$item['name']."'";
                        }
                        echo "><span class='fa-stack fa-lg pull-left'><i class='".$item['ico']."'></i></span>".$item['desc']."</a>";
                        if(is_array($item['parent'])) {
                            echo '<ul class="nav-pills nav-stacked" style="list-style-type:none;">';
                            foreach($item['parent'] as $subitem1) {
                                echo '<li ';
                                if($active_module==$subitem1['name']) echo " class='active'";
                                echo '>';
                                
                                echo '<a href="'.base_url().$subitem1['name'].'"><span class="fa-stack fa-lg pull-left"><i class="fa fa-chevron-right fa-stack-1x "></i></span>'.$subitem1['desc']."</a>";


								if(is_array($subitem1['parent'])) {
		                            echo '<ul class="nav-pills nav-stacked" style="list-style-type:none;">';
		                            foreach($subitem1['sub_pos'] as $subitem2) {
		                                echo '<li ';
		                                if(($active_module."/".$this->uri->segment(2).(($this->uri->segment(3)!="")?'/'.$this->uri->segment(3):''))==$subitem2['name']) echo " class='active'";
		                                echo '>';
		                                
		                                echo '<a href="'.base_url().$subitem2['name'].'"><span class="fa-stack fa-lg pull-left"><i class="fa fa-chevron-right fa-stack-1x "></i></span>'.$subitem2['desc']."</a>";
		                                echo '</li>';
		                            }
		                            echo '</ul>';
		                        }


                                echo '</li>';
                            }
                            echo '</ul>';
                        }
                        echo '</li>';
                    }
                    echo '<li>';
                    echo '<a href="'.base_url().'auth/logout"><span class="fa-stack fa-lg pull-left"><i class="fa fa-power-off"></i></span>Wyloguj się</a>';
                    echo '</li>';
                }
            ?>
            </ul>
        </div>
        
        <!-- /#sidebar-wrapper -->
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid xyz">
                <div class="row">
                    <div class="col-lg-12">
                    