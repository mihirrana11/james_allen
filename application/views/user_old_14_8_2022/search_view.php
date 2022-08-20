<!DOCTYPE html>

<html lang="en">


<!-- Mirrored from portotheme.com/html/molla/category.html by HTTrack Website Copier/3.x [XR&CO'2013], Mon, 23 Dec 2019 10:23:16 GMT -->
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vimla Prints</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <?php 
    include_once('head_file.php');
    ?>
</head>

<body>
    <div class="page-wrapper">
        <?php 
        include_once('header.php');
        ?>
        <main class="main">
            <?php 
            if(isset($menu_seo_slug) && $menu_seo_slug!="")
            {
             $front_menu_current_res=$this->db->get_where('tbl_front_menu',array('front_menu_seo_slug'=>$menu_seo_slug));

                 if($front_menu_current_res->num_rows()>0)
                 {
                    $front_menu_current_row=$front_menu_current_res->result();

                    ?>
                        <div class="page-header text-center" style="background-image: url('<?php echo base_url(); ?>files/admin/front_menu/<?php echo $front_menu_current_row[0]->front_menu_icon_image; ?>')">
                        <div class="container">
                            <?php 
                            if($front_menu_current_row[0]->front_menu_icon_image=="")
                            {
                            ?>
                            <h1 class="page-title"><?php echo $front_menu_current_row[0]->front_menu_banner_title; ?>
                            </h1>
                            <?php 
                            }
                            ?>
                            
                        </div><!-- End .container -->
                    </div><!-- End .page-header -->
                    <?php
                 }
            }
            ?>
        	<!--<div class="page-header text-center" style="background-image: url('<?php echo base_url(); ?>template/user/assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">Grid 3 Columns<span>Shop</span></h1>
        		</div>
        	</div>-->
            
            <!-- breadcums -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user">Home</a></li>
                        <!--<li class="breadcrumb-item"><a href="#">Shop</a></li>-->
                        <li class="breadcrumb-item active" aria-current="page">
                            <?php 
                            if(isset($menu_seo_slug) && $menu_seo_slug!="")
                            {
                             echo $front_menu_current_row[0]->front_menu_banner_title." - "; 
                            }
                            ?> <?php echo $total_products; ?> items</li>
                            
                    </ol>
                </div>
            </nav>
            <!-- breadcums end -->



            <div class="page-content">
                <div class="container">
                	<div class="row">
                		<div class="col-lg-10">
                            
                            <!-- breadcums -->
                			<!--<div class="toolbox">
                				<div class="toolbox-left">
                					<div class="toolbox-info">
                						Showing <span>9 of 56</span> Products
                					</div>
                				</div>
                				<div class="toolbox-right">
                					<div class="toolbox-sort">
                						<label for="sortby">Sort by:</label>
                						<div class="select-custom">
											<select name="sortby" id="sortby" class="form-control">
												<option value="popularity" selected="selected">Most Popular</option>
												<option value="rating">Most Rated</option>
												<option value="date">Date</option>
											</select>
										</div>
                					</div>
                					<div class="toolbox-layout">
                						<a href="category-list.html" class="btn-layout">
                							<svg width="16" height="10">
                								<rect x="0" y="0" width="4" height="4" />
                								<rect x="6" y="0" width="10" height="4" />
                								<rect x="0" y="6" width="4" height="4" />
                								<rect x="6" y="6" width="10" height="4" />
                							</svg>
                						</a>

                						<a href="category-2cols.html" class="btn-layout">
                							<svg width="10" height="10">
                								<rect x="0" y="0" width="4" height="4" />
                								<rect x="6" y="0" width="4" height="4" />
                								<rect x="0" y="6" width="4" height="4" />
                								<rect x="6" y="6" width="4" height="4" />
                							</svg>
                						</a>

                						<a href="category.html" class="btn-layout active">
                							<svg width="16" height="10">
                								<rect x="0" y="0" width="4" height="4" />
                								<rect x="6" y="0" width="4" height="4" />
                								<rect x="12" y="0" width="4" height="4" />
                								<rect x="0" y="6" width="4" height="4" />
                								<rect x="6" y="6" width="4" height="4" />
                								<rect x="12" y="6" width="4" height="4" />
                							</svg>
                						</a>

                						<a href="category-4cols.html" class="btn-layout">
                							<svg width="22" height="10">
                								<rect x="0" y="0" width="4" height="4" />
                								<rect x="6" y="0" width="4" height="4" />
                								<rect x="12" y="0" width="4" height="4" />
                								<rect x="18" y="0" width="4" height="4" />
                								<rect x="0" y="6" width="4" height="4" />
                								<rect x="6" y="6" width="4" height="4" />
                								<rect x="12" y="6" width="4" height="4" />
                								<rect x="18" y="6" width="4" height="4" />
                							</svg>
                						</a>
                					</div>
                				</div>
                			</div>-->
                            <!-- breadcums end -->

                            <div class="products mb-3">
                                <div class="row justify-content-center"  id="product_div">
                                    <?php 
                                    //$product_res=$this->db->get_where("tbl_product_new");
                                    if(isset($product_res))
                                    {
                                        foreach($product_res->result() as $product_row)
                                        {
                                        ?>
                                        <div class="col-6 col-md-4 col-lg-4">
                                            <div class="product product-7 text-center">
                                                <figure class="product-media">
                                                    <!--<span class="product-label label-new">New</span>-->
                                                    <?php 
                                                        if($product_row->product_quantity==0)
                                                        {
                                                            ?>
                                                            <span class="product-label label-primary">Out of Stock</span>
                                                            <?php
                                                        }
                                                        ?>
                                                    <!--<a href="<?php echo base_url(); ?>user/product/<?php echo $product_row->product_id; ?>">-->
                                                    <!--<a href="<?php echo base_url(); ?>user/product/<?php echo $product_row->product_seo_slug; ?>/<?php echo $product_row->product_id; ?>">-->
                                                    <a href="<?php echo base_url(); ?>user/product/<?php echo $product_row->product_seo_slug; ?>">
                                                        <img src="<?php echo base_url(); ?>files/admin/product/med/<?php echo $product_row->product_image; ?>" alt="Product image" class="product-image">
                                                    </a>

                                                    <div class="product-action-vertical">
                                                        <!--<a href="//send?text=Text to send withe message: http://www.yoursite.com" class="btn-product-icon icon-whatsapp btn-expandable"><span>Share on Whatsapp</span></a>-->
                                                        <a href="https://web.whatsapp.com/send?text=Please check this product: <?php echo base_url(); ?>user/product/<?php echo $product_row->product_seo_slug; ?>" data-action="share/whatsapp/share" target="_blank" class="btn-product-icon icon-whatsapp btn-expandable"><span>Share on Whatsapp</span></a>

                                                        <!--<a href="<?php echo base_url(); ?>user/wishlist_add/<?php echo $product_row->product_id; ?>" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>-->

                                                        <?php 
                                                            //in_array(needle, haystack)
                                                            if(isset($wishlist_array) && in_array($product_row->product_id, $wishlist_array))
                                                            {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>user/wishlist_add/<?php echo $product_row->product_id; ?>" class="btn-product-icon selected-wishlist "></a>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>user/wishlist_add/<?php echo $product_row->product_id; ?>" class="btn-product-icon btn-wishlist btn-expandable"><span>add to wishlist</span></a>
                                                                <?php
                                                            }
                                                            ?>
                                                        <a href="popup/quickView.html" class="btn-product-icon btn-quickview btn-expandable" title="Quick view "><span>Quick view</span></a>
                                                        <!--<a href="#" class="btn-product-icon btn-compare" title="Compare"><span>Compare</span></a>-->
                                                    </div><!-- End .product-action-vertical -->

                                                    <div class="product-action">
                                                        <!--<a href="<?php echo base_url(); ?>user/add_to_cart/<?php echo $product_row->product_id; ?>" class="btn-product btn-cart"><span>add to cart</span></a>-->
                                                        <?php 
                                                            if($product_row->product_quantity==0)
                                                            {
                                                                ?>
                                                                <!--<span class="product-label label-primary">Out of Stock</span>-->
                                                                <a href="<?php echo base_url(); ?>user/notify_me/<?php echo $product_row->product_id; ?>" class="btn-product"><span>Notify Me</span></a>
                                                                <?php
                                                            }
                                                            else
                                                            {
                                                                ?>
                                                                <a href="<?php echo base_url(); ?>user/add_to_cart/<?php echo $product_row->product_id; ?>" class="btn-product btn-cart"><span>add to cart</span></a>
                                                                <?php
                                                            }
                                                            ?>


                                                    </div><!-- End .product-action -->
                                                </figure><!-- End .product-media -->

                                                <div class="product-body">
                                                    
                                                    <!--
                                                    <div class="product-cat">
                                                        <a href="#">Women</a>
                                                    </div>
                                                    -->

                                                    <!-- End .product-cat -->
                                                    <h3 class="product-title">
                                                        <!--<a href="<?php echo base_url(); ?>user/product/<?php echo $product_row->product_id; ?>">-->
                                                        <!--<a href="<?php echo base_url(); ?>user/product/<?php echo $product_row->product_seo_slug; ?>/<?php echo $product_row->product_id; ?>">-->
                                                        <a href="<?php echo base_url(); ?>user/product/<?php echo $product_row->product_seo_slug; ?>">
                                                            <?php echo $product_row->product_name; ?>
                                                        </a>
                                                    </h3><!-- End .product-title -->
                                                    
                                                    <!--<div class="product-price">
                                                        $60.00
                                                    </div>-->
                                                    <div class="product-price">
                                                        <!--Rs.--><i class="icon-rupee"></i> <?php echo $product_row->product_selling_price; ?>
                                                    </div>
                                                    
                                                    <!-- End .product-price -->
                                                    <!--
                                                    <div class="ratings-container">
                                                        <div class="ratings">
                                                            <div class="ratings-val" style="width: 20%;"></div>
                                                        </div>
                                                        <span class="ratings-text">( 2 Reviews )</span>
                                                    </div>

                                                    <div class="product-nav product-nav-thumbs">
                                                        <a href="#" class="active">
                                                            <img src="<?php echo base_url(); ?>template/user/assets/images/products/product-4-thumb.jpg" alt="product desc">
                                                        </a>
                                                        <a href="#">
                                                            <img src="<?php echo base_url(); ?>template/user/assets/images/products/product-4-2-thumb.jpg" alt="product desc">
                                                        </a>

                                                        <a href="#">
                                                            <img src="<?php echo base_url(); ?>template/user/assets/images/products/product-4-3-thumb.jpg" alt="product desc">
                                                        </a>
                                                    </div>-->

                                                    <!-- End .product-nav -->
                                                </div><!-- End .product-body -->
                                            </div><!-- End .product -->
                                        </div><!-- End .col-sm-6 col-lg-4 -->
                                        <?php
                                        }
                                    }
                                    ?>
                                    
                                </div><!-- End .row -->
                                <center>
                                    <img id="loading_img" src="<?php echo base_url(); ?>template/user/images/loading.gif" style="visibility: hidden;display:none" height="200px">


                                    <!--
                                    <button type="button" onclick="load_more();" class="visible-xs-block visible-sm-block">Load More</button>
                                    -->

                                    <button type="button" onclick="load_more();" class="btn btn-outline-primary-2 btn-minwidth-sm visible-xs-block visible-sm-block">
                                        <span>Load More</span>
                                        <i class="icon-long-arrow-down"></i>
                                    </button>


                                </center>
                                
                            </div><!-- End .products -->

                			<!--<nav aria-label="Page navigation">
							    <ul class="pagination justify-content-center">
							        <li class="page-item disabled">
							            <a class="page-link page-link-prev" href="#" aria-label="Previous" tabindex="-1" aria-disabled="true">
							                <span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev
							            </a>
							        </li>
							        <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
							        <li class="page-item"><a class="page-link" href="#">2</a></li>
							        <li class="page-item"><a class="page-link" href="#">3</a></li>
							        <li class="page-item-total">of 6</li>
							        <li class="page-item">
							            <a class="page-link page-link-next" href="#" aria-label="Next">
							                Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>
							            </a>
							        </li>
							    </ul>
							</nav>-->
                		</div><!-- End .col-lg-9 -->
                		<?php 
                        include_once('category_left_menu.php');
                        ?>
                	</div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

        <?php 
        include_once('footer.php');
        ?>
    </div><!-- End .page-wrapper -->
    <?php 
    include_once('mobile_menu.php');
    ?>

    <?php
    include_once('category_footer_file.php');
    ?>
</body>


<!-- Mirrored from portotheme.com/html/molla/category.html by HTTrack Website Copier/3.x [XR&CO'2013], Mon, 23 Dec 2019 10:24:05 GMT -->
</html>

<style type="text/css">
    .toolbox .form-control 
    {
        color: black;
        font-weight: 300;
        font-size: 1.2rem;
    }
</style>

<script type="text/javascript">
            var controller = "ajax/get_city";
            var base_url = "<?php echo base_url(); ?>";

     function getXMLHTTP() { //fuction to return the xml http object
        var xmlhttp=false;  
        try{
            xmlhttp=new XMLHttpRequest();
        }
        catch(e)    {       
            try{            
                xmlhttp= new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch(e){
                try{
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(e){
                    xmlhttp=false;
                }
            }
        }
            
        return xmlhttp;
    }

    function next_paging_data(next_page_no)
    {       
        var qry_str=document.getElementById('txt_query_string').value;
        var strURL=base_url+"user_ajax/next_paging_data_new"+"/"+next_page_no+"?"+qry_str;
        //alert(strURL);
        alert(strURL);
        
        var req = getXMLHTTP();
        if (req) {
            req.onreadystatechange = function() {
                if (req.readyState == 4) {
                    // only if "OK"
                    if (req.status == 200) {
                    //alert(req.responseText);                      
                        document.getElementById('loading_img').style.visibility="hidden";
                        document.getElementById('loading_img').style.display="none";

                        document.getElementById("product_div").innerHTML=document.getElementById("product_div").innerHTML+req.responseText;
                        
                    } else {
                        alert("There was a problem while using XMLHTTP:\n" + req.statusText);
                    }
                }               
            }           
            req.open("GET", strURL, true);
            req.send(null);
            
        }
        
    }

    
</script>
<input type="hidden" id="txt_page_no" name="txt_page_no" value="1">
<script type="text/javascript">

    $(window).scroll(function() {

        if($(window).scrollTop() + $(window).height() >= $(document).height()) {

            //var last_id = $(".post-id:last").attr("id");

            //loadMoreData(last_id);

            //alert("page load event");
            document.getElementById('loading_img').style.visibility="visible";
            document.getElementById('loading_img').style.display="block";
            

            var next_page_id = parseInt(document.getElementById('txt_page_no').value) + 1;

            document.getElementById('txt_page_no').value=next_page_id;
            next_paging_data(next_page_id);
            
            //alert(next_page_id);


        }

    });
</script>
<script type="text/javascript">
    function load_more()
    {
        var next_page_id = parseInt(document.getElementById('txt_page_no').value) + 1;

            document.getElementById('txt_page_no').value=next_page_id;
            next_paging_data(next_page_id);    
    }
</script>

<!-- Responsive Utilities -->
<style type="text/css">
    @-ms-viewport {
    width: device-width
}

.visible-lg,
.visible-md,
.visible-sm,
.visible-xs {
    display: none!important
}

.visible-lg-block,
.visible-lg-inline,
.visible-lg-inline-block,
.visible-md-block,
.visible-md-inline,
.visible-md-inline-block,
.visible-sm-block,
.visible-sm-inline,
.visible-sm-inline-block,
.visible-xs-block,
.visible-xs-inline,
.visible-xs-inline-block {
    display: none!important
}

@media (max-width:767px) {
    .visible-xs {
        display: block!important
    }
    table.visible-xs {
        display: table!important
    }
    tr.visible-xs {
        display: table-row!important
    }
    td.visible-xs,
    th.visible-xs {
        display: table-cell!important
    }
}

@media (max-width:767px) {
    .visible-xs-block {
        display: block!important
    }
}

@media (max-width:767px) {
    .visible-xs-inline {
        display: inline!important
    }
}

@media (max-width:767px) {
    .visible-xs-inline-block {
        display: inline-block!important
    }
}

@media (min-width:768px) and (max-width:991px) {
    .visible-sm {
        display: block!important
    }
    table.visible-sm {
        display: table!important
    }
    tr.visible-sm {
        display: table-row!important
    }
    td.visible-sm,
    th.visible-sm {
        display: table-cell!important
    }
}

@media (min-width:768px) and (max-width:991px) {
    .visible-sm-block {
        display: block!important
    }
}

@media (min-width:768px) and (max-width:991px) {
    .visible-sm-inline {
        display: inline!important
    }
}

@media (min-width:768px) and (max-width:991px) {
    .visible-sm-inline-block {
        display: inline-block!important
    }
}

@media (min-width:992px) and (max-width:1199px) {
    .visible-md {
        display: block!important
    }
    table.visible-md {
        display: table!important
    }
    tr.visible-md {
        display: table-row!important
    }
    td.visible-md,
    th.visible-md {
        display: table-cell!important
    }
}

@media (min-width:992px) and (max-width:1199px) {
    .visible-md-block {
        display: block!important
    }
}

@media (min-width:992px) and (max-width:1199px) {
    .visible-md-inline {
        display: inline!important
    }
}

@media (min-width:992px) and (max-width:1199px) {
    .visible-md-inline-block {
        display: inline-block!important
    }
}

@media (min-width:1200px) {
    .visible-lg {
        display: block!important
    }
    table.visible-lg {
        display: table!important
    }
    tr.visible-lg {
        display: table-row!important
    }
    td.visible-lg,
    th.visible-lg {
        display: table-cell!important
    }
}

@media (min-width:1200px) {
    .visible-lg-block {
        display: block!important
    }
}

@media (min-width:1200px) {
    .visible-lg-inline {
        display: inline!important
    }
}

@media (min-width:1200px) {
    .visible-lg-inline-block {
        display: inline-block!important
    }
}

@media (max-width:767px) {
    .hidden-xs {
        display: none!important
    }
}

@media (min-width:768px) and (max-width:991px) {
    .hidden-sm {
        display: none!important
    }
}

@media (min-width:992px) and (max-width:1199px) {
    .hidden-md {
        display: none!important
    }
}

@media (min-width:1200px) {
    .hidden-lg {
        display: none!important
    }
}
.btn-expandable {

    position: relative;
    font-size: 17px;

}
.btn-expandable:hover {

    position: relative;
    font-size: 20px;

}
</style>
<!-- Responsive Utilities -->

