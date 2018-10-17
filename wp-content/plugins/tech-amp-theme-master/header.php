<?php 
headerbody_classes();
amp_header_core(); ?>

<?php amp_sidebar(['action'=>'start',
    'id'=>'sidebar',
    'layout'=>'nodisplay',
    'side'=>'right'
] ); ?>
<div class="amp-close-btn">
    <?php amp_sidebar(['action'=>'close-button']); ?>
</div>
<div class="amp-main-menu">
    <?php amp_menu(); ?>
</div><!-- /.amp-menu -->
<?php amp_sidebar(['action'=>'end']); ?>


<div class="featured-img-w">
    <div class="no-img-bg">
     <header class="header cntr">
        <div class="head">
            <div class="nav">
                <a class="lb" href="#menu">
                    <amp-img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMS4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUzIDUzIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCA1MyA1MzsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHdpZHRoPSIxNnB4IiBoZWlnaHQ9IjE2cHgiPgo8Zz4KCTxnPgoJCTxwYXRoIGQ9Ik0yLDEzLjVoNDljMS4xMDQsMCwyLTAuODk2LDItMnMtMC44OTYtMi0yLTJIMmMtMS4xMDQsMC0yLDAuODk2LTIsMlMwLjg5NiwxMy41LDIsMTMuNXoiIGZpbGw9IiNGRkZGRkYiLz4KCQk8cGF0aCBkPSJNMiwyOC41aDQ5YzEuMTA0LDAsMi0wLjg5NiwyLTJzLTAuODk2LTItMi0ySDJjLTEuMTA0LDAtMiwwLjg5Ni0yLDJTMC44OTYsMjguNSwyLDI4LjV6IiBmaWxsPSIjRkZGRkZGIi8+CgkJPHBhdGggZD0iTTIsNDMuNWg0OWMxLjEwNCwwLDItMC44OTYsMi0ycy0wLjg5Ni0yLTItMkgyYy0xLjEwNCwwLTIsMC44OTYtMiwyUzAuODk2LDQzLjUsMiw0My41eiIgZmlsbD0iI0ZGRkZGRiIvPgoJPC9nPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" width="30" height="20" />            
                </a>
                <div class="lb-btn"> 
                </div>
            </div><!-- /.nav -->
            <div class="logo">
                <?php amp_logo(); ?>
            </div><!-- /.logo-amp -->
            <div class="search">
                <a class="lb" href="#ovelay">
                    <amp-img src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDU2Ljk2NiA1Ni45NjYiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDU2Ljk2NiA1Ni45NjY7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iMTZweCIgaGVpZ2h0PSIxNnB4Ij4KPHBhdGggZD0iTTU1LjE0Niw1MS44ODdMNDEuNTg4LDM3Ljc4NmMzLjQ4Ni00LjE0NCw1LjM5Ni05LjM1OCw1LjM5Ni0xNC43ODZjMC0xMi42ODItMTAuMzE4LTIzLTIzLTIzcy0yMywxMC4zMTgtMjMsMjMgIHMxMC4zMTgsMjMsMjMsMjNjNC43NjEsMCw5LjI5OC0xLjQzNiwxMy4xNzctNC4xNjJsMTMuNjYxLDE0LjIwOGMwLjU3MSwwLjU5MywxLjMzOSwwLjkyLDIuMTYyLDAuOTIgIGMwLjc3OSwwLDEuNTE4LTAuMjk3LDIuMDc5LTAuODM3QzU2LjI1NSw1NC45ODIsNTYuMjkzLDUzLjA4LDU1LjE0Niw1MS44ODd6IE0yMy45ODQsNmM5LjM3NCwwLDE3LDcuNjI2LDE3LDE3cy03LjYyNiwxNy0xNywxNyAgcy0xNy03LjYyNi0xNy0xN1MxNC42MSw2LDIzLjk4NCw2eiIgZmlsbD0iI0ZGRkZGRiIvPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K" width="16" height="16" />                
                </a>
                <div class="lb-btn"> 
                    <div class="lb-tg" id="ovelay">
                       <?php amp_search();?>
                       <a class="lb-x" href="#"></a>
                    </div> 
                </div>
            </div><!-- /.search -->
            
            <div class="clearfix"></div>
        </div>
    </header>
    </div>

<?php
    if(ampforwp_is_home() && !ampforwp_is_front_page() && !is_single() ){
?>
<div class="home-bg">
    <div class="featured-img-bp">
        <?php
        if (get_query_var( 'paged' ) ) {
                $paged = get_query_var('paged');
            } elseif ( get_query_var( 'page' ) ) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            } 
        if($paged<=1){
        $args = array('post_to_show'=>1);
        while(amp_loop('start',$args)): ?>
        <div class="loop-post">
            <?php 
            //array('thumbnail', 'medium', 'medium_large', 'large');
            $args = array("tag"=>'div',"tag_class"=>'image-container','image_size'=>'medium_large', 'responsive'=> true); ?>
            <?php if ( has_post_thumbnail()): ?>
            <div class="featured-img">
                <?php amp_loop_image($args); ?>
            </div><!-- /.featured-image -->
            <div class="featured-img-cnt">
                <?php amp_loop_category(); ?>
                <?php amp_loop_title(); ?>
            </div><!-- /.featured-image-post-content -->
            <?php else: ?>
            <div class="featured-no-img-cnt">
                <?php amp_loop_category(); ?>
                <?php amp_loop_title(); ?>
            </div><!-- /.featured-image-post-content -->
            <?php endif; ?>
        </div>
    <?php endwhile;  amp_loop('end');  
        amp_reset_loop();
        }  ?>
    </div><!-- /.featured-image-big-post -->
</div><!-- /.home-background -->
<?php } ?>
</div><!-- /.featured-image-wrapper -->
<div class="content-wrapper">

                <div class="lb-tg" id="menu">
                   <div class="menu">
                       <?php amp_menu(); ?>
                    </div><!-- /.amp-menu -->
                   <a class="lb-x" href="#"></a>
                </div> 
