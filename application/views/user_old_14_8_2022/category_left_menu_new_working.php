
<aside class="col-lg-2 order-lg-first">
	
                			<div class="sidebar sidebar-shop">
                				<!--<div class="widget widget-clean">

                					<label>Filters:</label>
                					<a href="#" class="sidebar-filter-clear">Clean All</a>
                				</div>-->

                				
                				<!--<div class="widget widget-collapsible">
	    								<h3 class="widget-title">
										    <a data-toggle="collapse" href="#widget-100" role="button" aria-expanded="true" aria-controls="widget-100">
										        Category
										    </a>
										</h3>

										
											<div class="collapse show" id="widget-100">
												<div class="widget-body">
													<div class="filter-items">
														<?php 
														$cat_res=$this->db->get_where('tbl_category',array('parent_id'=>0));
														foreach($cat_res->result() as 
															$cat_row)
														{
														?>
														<div class="filter-item">
															<div class="custom-control custom-checkbox">
																<input 
																<?php 
																if(in_array($cat_row->category_id, $cat_array))
																{
																	//echo "checked='checked'";
																	?>
																	onchange="remove_cat_attr('category',<?php echo $cat_row->category_id; ?>)"
																	<?php
																}
																else
																{
																	?>
																	onchange="callme('category',<?php echo $cat_row->category_id; ?>)"
																	<?php
																}
																?>
																 type="checkbox"
																<?php 
																if(in_array($cat_row->category_id, $cat_array))
																{
																	echo "checked='checked'";
																}
																?> class="custom-control-input" id="search-<?php echo $cat_row->category_id; ?>">
																<label class="custom-control-label" for="search-<?php echo $cat_row->category_id; ?>"><?php echo $cat_row->category_name; ?></label>
															</div>
														</div>
														
														<?php 
														}
														?>

														
													</div>
												</div>
											</div>
										
	        					</div>--><!-- End .widget -->

        						<?php 
        						$this->db->order_by('attribute_order','asc');
        						$attribute_res=$this->db->get_where('tbl_attribute');
        						$cnt=10;
        						foreach($attribute_res->result() as $attribute_row)
        						{
        							$attribute_type=$attribute_row->attribute_type;
        							?>
        							<div class="widget widget-collapsible">
	    								<h3 class="widget-title">
										    <a data-toggle="collapse" href="#widget-<?php echo $cnt; ?>" role="button" aria-expanded="true" aria-controls="widget-<?php echo $cnt; ?>">
										        <?php echo $attribute_row->attribute_display_title; ?>
										    </a>
										</h3><!-- End .widget-title -->

										<?php 
										if($attribute_type=="Select")
										{
										?>
											<div class="collapse show" id="widget-<?php echo $cnt; ?>">
												<div class="widget-body">
													<div class="filter-items">
														<?php 
														$attr_value_res=$this->db->get_where('tbl_attribute_value',array('attribute_id'=>$attribute_row->attribute_id));
														foreach($attr_value_res->result() as 
															$attr_value_row)
														{
														?>
														<div class="filter-item">
															<div class="custom-control custom-checkbox">
																<input

																<?php 
																if(in_array($attr_value_row->attribute_value_id, $attr_array))
																{
																	//echo "checked='checked'";
																	?>
																	onchange="remove_cat_attr('attr',<?php echo $attr_value_row->attribute_value_id; ?>)"
																	<?php
																}
																else
																{
																	?>
																	onchange="callme('attr',<?php echo $attr_value_row->attribute_value_id; ?>)"
																	<?php

																}
																?>
																 type="checkbox" 

																<?php 
																if(in_array($attr_value_row->attribute_value_id, $attr_array))
																{
																	echo "checked='checked'";
																}
																?>
																class="custom-control-input" id="search-attr-<?php echo $attr_value_row->attribute_value_id; ?>">
																<label class="custom-control-label" for="search-attr-<?php echo $attr_value_row->attribute_value_id; ?>"><?php echo $attr_value_row->attribute_value; ?></label>
															</div><!-- End .custom-checkbox -->
														</div><!-- End .filter-item -->
														<?php 
														}
														?>

														
													</div><!-- End .filter-items -->
												</div><!-- End .widget-body -->
											</div><!-- End .collapse -->
										<?php 
										}
										else if($attribute_type=="Color/Pattern")
										{
										?>
											<div class="collapse show" id="widget-<?php echo $cnt; ?>">
												<div class="widget-body">
													<div class="filter-colors">
													<?php 
														$attr_value_res=$this->db->get_where('tbl_attribute_value',array('attribute_id'=>$attribute_row->attribute_id));
														foreach($attr_value_res->result() as 
															$attr_value_row)
														{
															?>
															<a 

															<?php 
																if(in_array($attr_value_row->attribute_value_id, $attr_array))
																{
																	//echo "checked='checked'";
																	?>
																	href="<?php echo base_url(); ?>user/remove_search_query/attr/<?php echo $attr_value_row->attribute_value_id; ?>" 
																	<?php
																}
																else
																{
																	?>
																	href="<?php echo base_url(); ?>user/search_query/attr/<?php echo $attr_value_row->attribute_value_id; ?>" title="<?php echo $attr_value_row->attribute_value; ?>"
																	<?php

																}
																?>

															

																<?php 
																if(in_array($attr_value_row->attribute_value_id, $attr_array))
																{
																	echo "class='selected'";
																}
																?>

															 style="background:<?php echo $attr_value_row->attribute_value_color_hexcode; ?>"><span class="sr-only"><?php echo $attr_value_row->attribute_value; ?></span>
															 <?php
															 if(trim($attr_value_row->attribute_value_pattern_img)!="")
															{
															 	?>
															 <img src="<?php echo base_url(); ?>files/admin/pattern/<?php echo $attr_value_row->attribute_value_pattern_img; ?>">
															 <?php 
															}
															 ?>
															</a>
															<?php
														}
														?>
														<!--<a href="#" style="background: #b87145;"><span class="sr-only">Color Name</span></a>
														<a href="#" style="background: #f0c04a;"><span class="sr-only">Color Name</span></a>
														<a href="#" style="background: #333333;"><span class="sr-only">Color Name</span></a>
														<a href="#" class="selected" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>
														<a href="#" style="background: #3399cc;"><span class="sr-only">Color Name</span></a>
														<a href="#" style="background: #669933;"><span class="sr-only">Color Name</span></a>
														<a href="#" style="background: #f2719c;"><span class="sr-only">Color Name</span></a>
														<a href="#" style="background: #ebebeb;"><span class="sr-only">Color Name</span></a>-->
													</div><!-- End .filter-colors -->
												</div><!-- End .widget-body -->
											</div><!-- End .collapse -->
										<?php 
										}
										?>
	        						</div><!-- End .widget -->
        							<?php
        							$cnt++;
        						}
        						?>
        						<!--
        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-1" role="button" aria-expanded="true" aria-controls="widget-1">
									        Category
									    </a>
									</h3>

									<div class="collapse show" id="widget-1">
										<div class="widget-body">
											<div class="filter-items filter-items-count">
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="cat-1">
														<label class="custom-control-label" for="cat-1">Dresses</label>
													</div>
													<span class="item-count">3</span>
												</div>

												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="cat-2">
														<label class="custom-control-label" for="cat-2">T-shirts</label>
													</div>
													<span class="item-count">0</span>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="cat-3">
														<label class="custom-control-label" for="cat-3">Bags</label>
													</div>
													<span class="item-count">4</span>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="cat-4">
														<label class="custom-control-label" for="cat-4">Jackets</label>
													</div>
													<span class="item-count">2</span>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="cat-5">
														<label class="custom-control-label" for="cat-5">Shoes</label>
													</div>
													<span class="item-count">2</span>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="cat-6">
														<label class="custom-control-label" for="cat-6">Jumpers</label>
													</div>
													<span class="item-count">1</span>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="cat-7">
														<label class="custom-control-label" for="cat-7">Jeans</label>
													</div>
													<span class="item-count">1</span>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="cat-8">
														<label class="custom-control-label" for="cat-8">Sportwear</label>
													</div>
													<span class="item-count">0</span>
												</div>
											</div>
										</div>
									</div>
        						</div>

        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-2" role="button" aria-expanded="true" aria-controls="widget-2">
									        Size
									    </a>
									</h3>

									<div class="collapse show" id="widget-2">
										<div class="widget-body">
											<div class="filter-items">
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="size-1">
														<label class="custom-control-label" for="size-1">XS</label>
													</div>
												</div>

												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="size-2">
														<label class="custom-control-label" for="size-2">S</label>
													</div>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" checked id="size-3">
														<label class="custom-control-label" for="size-3">M</label>
													</div>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" checked id="size-4">
														<label class="custom-control-label" for="size-4">L</label>
													</div>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="size-5">
														<label class="custom-control-label" for="size-5">XL</label>
													</div>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="size-6">
														<label class="custom-control-label" for="size-6">XXL</label>
													</div>
												</div>
											</div>
										</div>
									</div>
        						</div>

        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-3" role="button" aria-expanded="true" aria-controls="widget-3">
									        Colour
									    </a>
									</h3>

									<div class="collapse show" id="widget-3">
										<div class="widget-body">
											<div class="filter-colors">
												<a href="#" style="background: #b87145;"><span class="sr-only">Color Name</span></a>
												<a href="#" style="background: #f0c04a;"><span class="sr-only">Color Name</span></a>
												<a href="#" style="background: #333333;"><span class="sr-only">Color Name</span></a>
												<a href="#" class="selected" style="background: #cc3333;"><span class="sr-only">Color Name</span></a>
												<a href="#" style="background: #3399cc;"><span class="sr-only">Color Name</span></a>
												<a href="#" style="background: #669933;"><span class="sr-only">Color Name</span></a>
												<a href="#" style="background: #f2719c;"><span class="sr-only">Color Name</span></a>
												<a href="#" style="background: #ebebeb;"><span class="sr-only">Color Name</span></a>
											</div>
										</div>
									</div>
        						</div>

        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-4" role="button" aria-expanded="true" aria-controls="widget-4">
									        Brand
									    </a>
									</h3>

									<div class="collapse show" id="widget-4">
										<div class="widget-body">
											<div class="filter-items">
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="brand-1">
														<label class="custom-control-label" for="brand-1">Next</label>
													</div>
												</div>

												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="brand-2">
														<label class="custom-control-label" for="brand-2">River Island</label>
													</div>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="brand-3">
														<label class="custom-control-label" for="brand-3">Geox</label>
													</div>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="brand-4">
														<label class="custom-control-label" for="brand-4">New Balance</label>
													</div>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="brand-5">
														<label class="custom-control-label" for="brand-5">UGG</label>
													</div>
												</div>

												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="brand-6">
														<label class="custom-control-label" for="brand-6">F&F</label>
													</div>
												</div>
												<div class="filter-item">
													<div class="custom-control custom-checkbox">
														<input type="checkbox" class="custom-control-input" id="brand-7">
														<label class="custom-control-label" for="brand-7">Nike</label>
													</div>
												</div>
											</div>
										</div>
									</div>
        						</div>-->
								
        						<div class="widget widget-collapsible">
    								<h3 class="widget-title">
									    <a data-toggle="collapse" href="#widget-5" role="button" aria-expanded="true" aria-controls="widget-5">
									        Price
									    </a>
									</h3><!-- End .widget-title -->

									<div class="collapse show" id="widget-5">
										<div class="widget-body">
                                            <div class="filter-price">
                                                <div class="filter-price-text">
                                                    Price :
                                                    <span id="filter-price-range"></span>
                                                </div><!-- End .filter-price-text -->

                                                <div id="price-slider"></div><!-- End #price-slider -->
                                            </div><!-- End .filter-price -->
										</div><!-- End .widget-body -->
									</div><!-- End .collapse -->
        						</div><!-- End .widget -->
                			</div><!-- End .sidebar sidebar-shop -->
</aside><!-- End .col-lg-3 -->

                	<script type="text/javascript">
						function callme(action,id)
						{
							window.location="<?php echo base_url(); ?>user/search_query/"+action+"/"+id;
						}

						function remove_cat_attr(action,id)
						{
							window.location="<?php echo base_url(); ?>user/remove_search_query/"+action+"/"+id;
						}


					</script>
						
						<input type="hidden" id="txt_base_url" name="txt_base_url" value="<?php echo base_url(); ?>">

						<input type="hidden" id="txt_query_string" name="txt_query_string" value="<?php echo $query_str; ?>">
						<input type="hidden" id="from_price" name="from_price">
						<input type="hidden" id="to_price" name="to_price">