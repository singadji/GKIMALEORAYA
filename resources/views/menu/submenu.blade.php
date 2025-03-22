<ul>
          <?php //if (!function_exists('createTreeView')) {
										function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) {
											foreach ($array as $menuId => $menu) {
											//echo $currentParent;
										if ($currentParent == $menu['id_parent']) {
											//if ($currLevel > $prevLevel) echo "<ul>";
								//if ($currLevel == $prevLevel) echo " </li> ";
											if($menu['isi_menu']==''){
								}
											$target='';
												if($menu['dokumen'] !='') $target='_blank';
																											
								if ($menu['link_menu']=='#'){?>
												<li class="dropdown"> <a class="" href="#"><span>{{ Str::words($menu['nama_menu']) }}</span> <i class="bi bi-chevron-down"></i></a>
											<?php }
											else{?>
												<li> <a class="" href="{{ asset($menu['link_menu']) }}">{{ Str::words($menu['nama_menu']) }} </a>
											<?php } 
								if ($currLevel <> $prevLevel) { $prevLevel = $currLevel; }
								$currLevel++; 
											echo '<ul class="">';
									createTreeView ($array, $menuId, $currLevel, $prevLevel);		
								echo '</ul>';
								$currLevel--;              
											}  
							}
							//if ($currLevel == $prevLevel) echo " </li>";
							} 
            //}
							$arrayMenu = array();
							foreach($nav_menu as $menua){
								$arrayMenu[$menua->id] = array("id" => $menua->id, "id_parent" => $menua->id_parent, "nama_menu" => $menua->nama_menu, "link_menu" => $menua->link_menu, "isi_menu" => $menua->isi_menu, "dokumen" => $menua->dokumen); 
							}
							createTreeView($arrayMenu, 0);
						?>
          </ul>