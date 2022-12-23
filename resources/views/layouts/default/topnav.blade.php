<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{url('Pages/home')}}" style="padding-top:3px">
                    <img src="{{asset('images/sign.png')}}" style="float:left; max-height:50px" />
                    <img src="{{asset('images/name.png')}}" style="float:left; max-height:50px; padding-left:15px;"  />
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <?php  $menu = getManu();
                        foreach($menu as $manueItem){
                    ?>
                    <li class="<?php echo ($manueItem['content_for'] == $selectedManu) ? 'active':'';?>" >
                        <?php if(!empty($manueItem['child'])){?>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Portfolio <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{url('Pages/'.$manueItem['content_for'])}}"><?php echo $manueItem['title'];?></a>
                            </li>
                            
                            <?php foreach($manueItem['child'] as $childTitle){ ?>
                                    <li>
                                    <a href="{{url('Pages/'.$childTitle['content_for'])}}">1 Column Portfolio</a>
                                        <div class="dd-handle"><?php echo $childTitle['title']; ?></div>
                                    </li>
                            <?php } ?>
                            </ul>
                        <?php }else{ ?>
                            <a href="{{url('Pages/'.$manueItem['content_for'])}}"><?php echo $manueItem['title'];?></a>
                        <?  } ?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>