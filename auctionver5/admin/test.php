<script type="text/javascript" src="admin/getCategory.js"></script>
			<div class="row">
				<h5>CATEGORY</h5>
				<br>
				<div class="input-field col s12 m4 l4">
					<select class="browser-default" name='mcat' id='mcat' onchange="setCategory(this.value)" REQUIRED>
						<option value = "" selected disabled>Select Main Category:</option>
						<?php
							$get = mysql_query("SELECT * FROM tbl_Main_Categories WHERE deleted = 0");
							if(!mysql_num_rows($get)==0){
								while($get_row = mysql_fetch_assoc($get)){
								?><option value = "<?php echo $get_row['main_category_ID']; ?>"><?php echo $get_row['main_category_name']; ?></option>
							<?php
								}
							}
						?>
					</select>
					<label class="black-text active" for="itemid">Main Category</label>
				</div>
				<div class="input-field col s12 m4 l4">
					<select class="browser-default" name='scate' id='scate' onchange="setSubCategory(this.value)" REQUIRED>
							<option value="" selected disabled>Select Category</option>	
					</select>

					<label class="black-text active" for="itemid">Category</label>
				</div>
				<div class="input-field col s12 m4 l4">
					<select class="browser-default" name='subcat' id='subcat' REQUIRED>
							<option value="" selected disabled>Select Sub Category</option>	
					</select>
					<label class="black-text active" for="itemid">Sub Category</label>
				</div>
			</div>