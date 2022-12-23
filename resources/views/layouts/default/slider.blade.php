<header id="myCarousel" class="carousel slide">
        <!-- Indicators -->
    <ol class="carousel-indicators">
        <? 
        $active = 'active';
        if(!empty($contentData->contentImage)){
            foreach ($contentData->contentImage as $index=>$image) {?>
                <li data-target="#myCarousel" data-slide-to="{{$index}}" class="<?php echo $active; ?>"></li>
            <?php $active = '';
            }
        }else if(!empty($property->propertyImage)){
            foreach ($property->propertyImage as $index=>$image) {?>
                <li data-target="#myCarousel" data-slide-to="{{$index}}" class="<?php echo $active; ?>"></li>
            <?php $active = '';
            }
        } else{ ?>
            <li data-target="#myCarousel" data-slide-to="0" class="<?php echo $active; ?>"></li>
        <?php } ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
        <? 
        $active = 'active';
        if(!empty($contentData->contentImage)){
            foreach ($contentData->contentImage as $index=>$image) {
                if($image->active == 1){
                ?>
                <div class="item <?php echo $active; ?>">

                     @if (!empty($image->path))
                        
                        <div class="fill" style="background-image:url('{{asset('user_images/'.$image->path)}}?&text={{$image->description}}');"></div>
                    @else
                        <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
                    @endif
                    <div class="carousel-caption">
                        <h2>{{$image->title}}</h2>
                    </div>
                </div>
                
            <?php $active = '';
                }
            }   
        }else if(!empty($property->propertyImage)){
            foreach ($property->propertyImage as $index=>$image) {
                if($image->active == 1){
                ?>
                <div class="item <?php echo $active; ?>">

                     @if (!empty($image->path))
                        
                        <div class="fill" style="background-image:url('{{asset('user_images/'.$image->path)}}?&text={{$image->description}}');"></div>
                    @else
                        <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
                    @endif
                    <div class="carousel-caption">
                        <h2>{{$image->title}}</h2>
                    </div>
                </div>
                
            <?php $active = '';
                }
            }
        }else{?>
            @if (!empty($contentData->image_path))                        
                <div class="fill" style="background-image:url('{{asset('user_images/'.$contentData->image_path)}}?&text={{$contentData->image_details}}');"></div>
            @else
                <div class="fill" style="background-image:url('http://placehold.it/1900x1080&text=Slide One');"></div>
            @endif
            <div class="carousel-caption">
                <h2>{{$contentData->image_title}}</h2>
            </div>
        <?php } ?>
    </div>

    <!-- Controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
        <span class="icon-prev"></span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
        <span class="icon-next"></span>
    </a>
</header>