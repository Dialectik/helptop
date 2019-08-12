<!--left-sidebar-->
	<div class="left-sidebar">
		<h2>@lang('layouts.categories')</h2>
		<dev class="panel-group category-products" id="menuVertical"> <!--category-productsr-->
		    <ul class="panel-title">
				@foreach($categories->where('section_id', $section_id) as $category)
				<li><a href="{{route('category.show', $category->id)}}">{{$category->title}}</a>
					<ul class="panel-body">
						@foreach($kinds->where('category_id', $category->id) as $kind)
							<li><a href="{{ route('kind.edit', $kind->id) }}">{{$kind->title}}</a></li>
						@endforeach
					</ul>
				</li>
				@endforeach
		    </ul>
		</dev><!--/category-products-->

		
		<h2>@lang('layouts.type_of_bidding')</h2>
		<div class="panel-group category-products" id="menuVertical2">
			<ul class="panel-title">
				@foreach($bidding_types as $bidding_type)
					<li><a href="{{ route('biddingtype.edit', $bidding_type->id) }}">{{ $bidding_type->title }}</a></li>
				@endforeach
			</ul>
		</div>
		
		
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