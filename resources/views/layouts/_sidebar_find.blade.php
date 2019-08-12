<!--left-sidebar-->
	<div>
		<form method="POST" action="{{ route('services.req') }}" > 
	  		@csrf
			<!--Передача данных для отображения на странице с другим количеством услуг-->
			<?php if(isset($services_title)) echo "<input type='hidden' name='services_title' value='$services_title' />" ?>
			<?php if(isset($in_content)) echo "<input type='hidden' name='in_content' value='$in_content' />" ?>
			<?php if(isset($product_code_id)) echo "<input type='hidden' name='product_code_id' value='$product_code_id' />" ?>
			<?php if(isset($section_id)) echo "<input type='hidden' name='section_id' value='$section_id' />" ?>
			<?php if(isset($section_title)) echo "<input type='hidden' name='section_title' value='$section_title' />" ?>
			<?php if(isset($category_id)) echo "<input type='hidden' name='category_id' value='$category_id' />" ?>
			<?php if(isset($category_title)) echo "<input type='hidden' name='category_title' value='$category_title' />" ?>
			<?php if(isset($kind_id)) echo "<input type='hidden' name='kind_id' value='$kind_id' />" ?>
			<?php if(isset($kind_title)) echo "<input type='hidden' name='kind_title' value='$kind_title' />" ?>
			<?php if(isset($bidding_id)) echo "<input type='hidden' name='bidding_id' value='$bidding_id' />" ?>
			<?php if(isset($bidding_title)) echo "<input type='hidden' name='bidding_title' value='$bidding_title' />" ?>
			<?php if(isset($date_on_start)) echo "<input type='hidden' name='date_on_start' value='$date_on_start' />" ?>
			<?php if(isset($date_on_end)) echo "<input type='hidden' name='date_on_end' value='$date_on_end' />" ?>
			<?php if(isset($date_off_start)) echo "<input type='hidden' name='date_off_start' value='$date_off_start' />" ?>
			<?php if(isset($date_off_end)) echo "<input type='hidden' name='date_off_end' value='$date_off_end' />" ?>
			<?php if(isset($price_f_min)) echo "<input type='hidden' name='price_f_min' value='$price_f_min' />" ?>
			<?php if(isset($price_f_max)) echo "<input type='hidden' name='price_f_max' value='$price_f_max' />" ?>
			<?php if(isset($price_s_min)) echo "<input type='hidden' name='price_s_min' value='$price_s_min' />" ?>
			<?php if(isset($price_s_max)) echo "<input type='hidden' name='price_s_max' value='$price_s_max' />" ?>
			<?php if(isset($region)) echo "<input type='hidden' name='region' value='$region' />" ?>
			<?php if(isset($city)) echo "<input type='hidden' name='city' value='$city' />" ?>
			<?php if(isset($district)) echo "<input type='hidden' name='district' value='$district' />" ?>
			<?php if(isset($bidding_bs)) echo "<input type='hidden' name='bidding_bs' value='$bidding_bs' />" ?>
			<input type="hidden" name="date_offset_p" id="date_offset_p"/>
			<!--Изменить количество услуг на странице-->
			<select class="col-sm-3" name="services_on_page">
				<option selected value="{{ $services_on_page }}">{{ $services_on_page }}</option>
				<option value="6">6</option>
				<option value="12">12</option>
				<option value="24">24</option>
				<option value="50">50</option>
			</select>
			&nbsp;
			<button type="submit" class="btn1" >
            	@lang('layouts.services_on_page')
        	</button>
		</form>
	</div>
	<div class="left-sidebar ">
		
		
		<p>&nbsp;</p>
		
		<h2>@lang('layouts.search_filters')</h2>
		
		<form method="POST" action="{{ route('services.req') }}" > 
	  		@csrf
		
		<button type="submit" class="btn1" >
            @lang('layouts.apply_filter')
        </button>
		
		<div class="clearfix" >
			<div class="bill-to">
				
				<div class="form-two" style="width: 100%">
					
						
						<?php if(isset($services_on_page)) echo "<input type='hidden' name='services_on_page' value='$services_on_page' />" ?>
						<p></p>
						<!-- Название услуги -->
						<textarea id="services_title" name="services_title"  placeholder="@lang('layouts.service_name')" rows="2">@if(isset($services_title)){{$services_title}}@else{{old('services_title')}}@endif</textarea>
						<p></p>
						<!-- Искать в описании услуги -->
						<div class="order-message">
							<label>
								<?php 
				                	$checked0 = null;
				                	if(isset($in_content)) $checked0 = 'checked';
				                	echo "<input type='checkbox' class='minimal' name='in_content' id='in_content' value='1' $checked0/>"; 
				                ?>
				                @lang('layouts.in_content')
			                </label>
						</div>
						<p></p>
						<!-- Пояснение в случае удаления товарного кода из запроса -->
				        <div id="code_un">
					        <div class="form-group alert alert-info" >
								@lang('layouts.service_code_warning')			
					        </div>
				        </div>
						<!-- Товарный код услуни-->
					    <input type="text" class="form-control" id="product_code" name="product_code_id" placeholder="@lang('layouts.service_code')" value="@if(isset($product_code_id)){{$product_code_id}}@else{{old('product_code_id')}}@endif">
						<p></p>
						<!-- Раздел -->
						<div class="order-message">
							<label>
				                @lang('layouts.sections') / @lang('layouts.categories') / @lang('layouts.kinds_sh')
			                </label>
						</div>
						<div>
							<select name="section_id" id="section_id">
				              	<option selected value="@if(isset($section_id)){{$section_id}}@else{{""}}@endif">
									@if(isset($section_title)) 
										{{ $section_title }}
									@else
										- @lang('layouts.choose_section') -
									@endif
								</option>
				              	
				              	@foreach($sections as $section)
			                		<option value="{{$section->id}}">{{$section->title}}</option>
			              		@endforeach
			              		<option value="">- @lang('layouts.choose_section') -</option>
							</select>
						</div>
						<p></p>
						<!-- Категория -->
						<div>
							<select name="category_id" id="category_id" style="width: 100%;">
								<option selected value="@if(isset($category_id)){{$category_id}}@else{{""}}@endif">
									@if(isset($category_title)) 
										{{ $category_title }}
									@else
										- @lang('layouts.choose_category') -
									@endif
								</option>
							</select>
						</div>
				        <p></p>
				        <!-- Вид услуг -->
						<div>
							<select name="kind_id" id="kind_id" style="width: 100%;">
								<option selected value="@if(isset($kind_id)){{$kind_id}}@else{{""}}@endif">
									@if(isset($kind_title)) 
										{{ $kind_title }}
									@else
										- @lang('layouts.choose_kind') -
									@endif
								</option>
							</select>
						</div>
						<p></p>
						<p></p>
						
						<!-- Тип торгов -->
						<div class="order-message">
							<label>
				                @lang('layouts.choose_bidding_type')
			                </label>
						</div>
						<div>
							<input type="hidden" id="bidding_type_h" value="@if(isset($bidding_id)){{$bidding_id}}@endif" />
							<select name="bidding_type" id="bidding_type">
								<option selected value="@if(isset($bidding_id)){{$bidding_id}}@else{{""}}@endif">
									@if(isset($bidding_title)) 
										{{ $bidding_title }}
									@else
										- @lang('layouts.bidding_types') -
									@endif
								</option>
								@foreach($bidding_types as $bidding_type)
									<option value="{{$bidding_type->id}}">{{$bidding_type->title}}</option>
								@endforeach
								<option value="">- @lang('layouts.bidding_types') -</option>
							</select>
						</div>
						
						<div class="order-message">
							<label>
				                @lang('layouts.bidding_bs')?
			                </label>
						</div>
						<div>
							<input type="hidden" id="bidding_bs_h" value="@if(isset($bidding_bs)){{$bidding_bs}}@endif" />
							<select name="bidding_bs" id="bidding_bs">
								<option selected value="@if(isset($bidding_bs)){{$bidding_bs}}@else{{""}}@endif">
									@if(isset($bidding_bs)) 
										@if($bidding_bs == 22)
											@lang('layouts.bidding_22')
										@endif
										@if($bidding_bs == 23)
											@lang('layouts.bidding_23')
										@endif
									@else
										- @lang('layouts.bidding_bs') -
									@endif
								</option>
								<option value="22">@lang('layouts.bidding_22')</option>
								<option value="23">@lang('layouts.bidding_23')</option>
								<option value="">- @lang('layouts.bidding_bs') -</option>
							</select>
						</div>
						<p></p>
						<p></p>

						<!-- Пояснение в случае не корректно указанных дат -->
				        <div id="date_un">
					        <div class="form-group alert alert-warning" >
								@lang('layouts.date_un')
					        </div>
				        </div>
						
						<!-- Диапазон дат публикации услуги -->
						<div class="order-message">
							<label>@lang('layouts.date_on'):</label>
						</div>
						<div class="form-group input-group date">
			                <div class="input-group-addon">
								<i class="fa fa-calendar"></i>
			                </div>
			                
			                <input type="text" class="form-control pull-right" id="datepicker" name="date_on_start" value="@if(isset($date_on_start)){{$date_on_start}}@else{{old('date_on_start')}}@endif" placeholder="@lang('layouts.date_from')">
						</div>
						<div class="form-group input-group date">
			                <div class="input-group-addon">
								<i class="fa fa-calendar"></i>
			                </div>
			                <input type="text" class="form-control pull-right" id="datepicker1" name="date_on_end" value="@if(isset($date_on_end)){{$date_on_end}}@else{{old('date_on_end')}}@endif" placeholder="@lang('layouts.date_to')">
						</div>
						
						<div class="order-message">
							<label>@lang('layouts.date_off'):</label>
						</div>
						<div class="form-group input-group date">
			                <div class="input-group-addon">
								<i class="fa fa-calendar"></i>
			                </div>
		                	<input type="text" class="form-control pull-right" id="datepicker2" name="date_off_start" value="@if(isset($date_off_start)){{$date_off_start}}@else{{old('date_off_start')}}@endif" placeholder="@lang('layouts.date_from')">
						</div>
						<div class="form-group input-group date">
			                <div class="input-group-addon">
								<i class="fa fa-calendar"></i>
			                </div>
			                <input type="text" class="form-control pull-right" id="datepicker3" name="date_off_end" value="@if(isset($date_off_end)){{$date_off_end}}@else{{old('date_off_end')}}@endif" placeholder="@lang('layouts.date_to')">
						</div>
						
						<!-- Скрытая передача смещения часового пояса пользователя относительно 'UTC'-->
	                	<input type="hidden" name="date_offset" id="date_offset" />
							
						<!-- Пояснение в случае указания некорректного диапазона цен -->
				        <div id="price_all">
					        <div class="form-group alert alert-warning" >
								@lang('layouts.price_all')
					        </div>
				        </div>
				        <!-- Пояснение в случае не выбранного типа торгов -->
				        <div id="price_type">
					        <div class="form-group alert alert-info" >
								@lang('layouts.price_type')
					        </div>
				        </div>
						
						<!-- Диапазон фиксированных цен услуг -->
						<div id="price_f">
							<div class="order-message">
								<label>@lang('layouts.price_f'):</label>
							</div>
							<div class="form-group ">
								<input type="text" class="form-control" id="price_f_min" placeholder="@lang('layouts.min_price')" name="price_f_min" value="@if(isset($price_f_min)){{$price_f_min}}@else{{old('price_f_min')}}@endif">               		<span>  грн</span>
				            </div>
				            <div class="form-group ">
								<input type="text" class="form-control" id="price_f_max" placeholder="@lang('layouts.max_price')" name="price_f_max" value="@if(isset($price_f_max)){{$price_f_max}}@else{{old('price_f_max')}}@endif">               		<span>  грн</span>
							</div>
						</div>
						
						<!-- Диапазон начальных цен услуг -->
						<div id="price_s">
							<div class="order-message">
								<label>@lang('layouts.price_s'):</label>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" id="price_s_min" placeholder="@lang('layouts.min_price')" name="price_s_min" value="@if(isset($price_s_min)){{$price_s_min}}@else{{old('price_s_min')}}@endif">               		<span>  грн</span>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" id="price_s_max" placeholder="@lang('layouts.max_price')" name="price_s_max" value="@if(isset($price_s_max)){{$price_s_max}}@else{{old('price_s_max')}}@endif">               		<span>  грн</span>
							</div>
						</div>
						
						<p></p>
						<p></p>  
						<!-- Адрес предоставления услуги -->
						<div class="order-message">
							<label>@lang('layouts.region_service'):</label>
						</div>
						<!-- Область -->
				
						<div class="form-group">
							<select class="form-control select2" name="region" id="region" style="width: 100%;" >
								<option value="@if(isset($region)){{$region}}@else{{""}}@endif">@if(isset($region)){{$region}}@else- @lang('layouts.choose_region') -@endif</option>
								@foreach($address as $addr)
									<option value="{{$addr->region}}">{{$addr->region}}</option>
								@endforeach
								<option value="">- @lang('layouts.choose_region') -</option>
							</select>
			            </div>
						<!-- Город -->
						<div class="order-message">
							<label>@lang('layouts.city'):</label>
						</div>
			            <div class="form-group">
							
							<select class="form-control select2" name="city" id="city" style="width: 100%;" >
							<option selected value="@if(isset($city)){{$city}}@else{{""}}@endif">
								@if(isset($city))
									{{$city}}
								@else
									- @lang('layouts.choose_city') -
								@endif
							</option>
							</select>
			            </div>
						<!-- Район -->
				        <div id="district_all">    
				            <div class="order-message">
								<label>@lang('layouts.district'):</label>
							</div>
				            <div class="form-group">
								<select class="form-control select2" name="district" id="district" style="width: 100%;">
								<option selected value="@if(isset($district)){{$district}}@else{{""}}@endif">
									@if(isset($district))
										{{$district}}
									@else
										- @lang('layouts.choose_district') -
									@endif
								</option>
								</select>
				            </div>
			            </div>
						
						

					
				</div>
			</div>
		</div>
		</form>
		
	
		
		
		
		<div class="shipping text-center"><!--shipping-->
			<a href="{{route('service.mysell.create')}}"><img src="/images/home/ban1.png" alt="" /></a>
		</div><!--/shipping-->
		
		<p>&nbsp;</p>
		
		
		<div class="brands_products"><!--с чего начать-->
			<h2>@lang('layouts.where_to_begin')</h2>
			<div >
				<ul class="nav nav-pills nav-stacked">
					<li><a href="/refer/6" class="nav-orange"><i class="fa fa-search"></i> &nbsp; @lang('layouts.how_search')</a></li>
					<li><a href="/refer/7" class="nav-orange"><i class="fa fa-coffee"></i> &nbsp; @lang('layouts.how_buy')</a></li>
					<li><a href="/refer/8" class="nav-orange"><i class="fa fa-money"></i> &nbsp; @lang('layouts.how_sell')</a></li>
					<li><a href="/refer/9" class="nav-orange"><i class="fa fa-plus-circle"></i> &nbsp; @lang('layouts.how_add')</a></li>
					<li><a href="/contacts" class="nav-orange"><i class="fa fa-envelope-o"></i> &nbsp; @lang('layouts.contacts')</a></li>
					
				</ul>
			</div>
		</div><!--/с чего начать-->
	
	</div>