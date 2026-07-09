<?php 
	function slide(){
		global $db,$smarty,$lang;
		$sql="SELECT * FROM slide ORDER BY sort DESC";		
		$arr=$db->getAssoc($sql);	
		
		if(!$arr){ return;}
		?>
          <div class="position-relative">
			<div class="position-relative site-slider">
            	<?php
				foreach($arr as $k=>$v){
				?>
					 <div>
					<div class="text-center text-white bg-cover align-items-center item" style="background-image: url(<?php echo _DOMAIN_ROOT_URL;?>/img/logo/<?php echo $v["logo"];?>)">
						<div class="container">
							<div class="row">
								<div class="col-12 col-lg-8 offset-lg-2">
									<div class="overflow-hidden p-2 wrap">
										<h2 class="font-family-secondary h4 text-shadow mb-3 title">
                                            <a href="<?php echo $v["link"];?>" style="font-size: 25px;">
												<span style="font-size: 45px;"><?php echo $v["name"];?></span>			
											</a>
                                         </h2>
                                    </div>
                                    <div class="overflow-hidden p-2 wrap">
										<p class="text-shadow mb-4 desc" style="font-size: 14px;"><?php echo $v["des"];?></p>
                                    </div>
									<div class="overflow-hidden p-2 wrap">
    									<a class="btn btn-primary" href="<?php echo $v["link"];?>">
    										Find more here			
    									</a>
                                    </div>
	                          </div>
							</div>
						</div>
					</div>
				</div>
				<?php
				}
				?>
          </div>
		</div>
    
<?php        		
	}
	//
?>