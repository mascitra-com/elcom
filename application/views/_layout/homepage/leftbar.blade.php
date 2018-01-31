<!--left column-->
<div class="col-lg-3 col-md-3 col-sm-12">
    <div class="panel-group" id="accordionNo">
        <!--Category-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" href="#collapseCategory" class="collapseWill active ">
                        <span class="pull-left"> <i class="fa fa-caret-right"></i></span> Kategori
                    </a>
                </h4>
            </div>

            <div id="collapseCategory" class="panel-collapse collapse in sidebar-category">
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked tree">
                        <?=$categories?>
                    </ul>
                </div>
            </div>
        </div>
        <!--/Category menu end-->
    </div>
    <div class="width100 section-block ">
        <a href="{{ $setting->banner_side_link }}" class="row featureImg">
            <div class="col-lg-12"><img src="{{ base_url('assets/images/banner/side/'.cek_file($setting->banner_side,'./assets/images/banner/side/','default.png')) }}"
             class="img-responsive" alt="img">
         </div>
     </a>
     <!--/.row-->
 </div>
</div>