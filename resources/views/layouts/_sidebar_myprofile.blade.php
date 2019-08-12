<!--left-sidebar-->
<div class="left-sidebar">
	<h2>Меню профиля</h2>
	<dev > <!--category-productsr-->
	    <ul class="nav nav-pills nav-stacked">
			<li><a href="{{ route('myprofile.index') }}" class="nav-orange"><i class="fa fa-cog"></i>&nbsp;&nbsp; @lang('layouts.pers_data')</a></li>
			<li><a href="{{ route('deals.index') }}" class="nav-orange"><i class="fa fa-suitcase"></i>&nbsp;&nbsp; @lang('layouts.deals')</a></li>
			<li><a href="" class="nav-orange"><i class="fa fa-eye"></i>&nbsp;&nbsp; @lang('layouts.biddings')</a></li>
			<li><a class="nav-orange" href="{{ route('service.mysell') }}"><i class="fa fa-gavel"></i>&nbsp;&nbsp; @lang('layouts.my_sale_ads')</a></li>
			<li><a class="nav-orange" href="{{ route('service.mybuy') }}"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp; @lang('layouts.my_purchase')</a></li>
			<li><a class="nav-orange" href="{{ route('scores.index') }}"><i class="fa fa-credit-card"></i>&nbsp;&nbsp; @lang('layouts.score')</a></li>
			<li><a class="nav-orange" href="{{ route('blurbs.index') }}"><i class="fa fa-magnet"></i>&nbsp;&nbsp; @lang('layouts.blurb')</a></li>
			<li><a class="nav-orange" href=""><i class="fa fa-star"></i>&nbsp;&nbsp; @lang('layouts.favorites')</a></li>
			<li ><a class="nav-orange" href="{{ route('messages.index') }}" <?php echo $message_mark ?> ><i class="fa fa-envelope-o"></i>&nbsp;&nbsp; @lang('layouts.messages')</a></li>
			<li><a class="nav-orange" href="{{ route('ratings.show', Auth::user()->id) }}"><i class="fa fa-heart"></i>&nbsp;&nbsp; @lang('layouts.rating')</a></li>
	    </ul>
	</dev><!--/category-products-->
	
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