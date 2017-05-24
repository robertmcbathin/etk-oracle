@extends('layouts.profile')
@section('description')
личный кабинет держателя карты ЕТК
@endsection
@section('keywords') 
@endsection
@section('title')
Личный кабинет
@endsection
@section('content')
<div class="page-header header-filter" data-parallax="active" style="background-image: url(&quot;/images/bgs/bg_index_tr.jpg&quot;); transform: translate3d(0px, 0px, 0px);">
</div>
<div class="main main-raised">
  <div class="profile-content">
    <div class="container">
    <div class="tab-pane">
      <div class="row">
        <div class="col-md-7 col-md-offset-1">
        <h4 class="title">Мои карты</h4>
          <div class="row collections">
           @foreach ($cards as $card)
              <div class="col-md-4">

<div class="card card-blog">
                    <div class="card-image">
                      <a href="#pablo">
                        <img class="img" src="/pictures/cards/thumbnails/160/{{$card->card_image_type}}.png">
                      </a>
                    <div class="colored-shadow" style="background-image: url(&quot;assets/img/examples/card-blog1.jpg&quot;); opacity: 1;"></div><div class="ripple-container"></div></div>

                    <div class="card-content">
                      <h4 class="title text-center">{{ $card->number }}</h4>
                      <h6 class="category text-gray text-center">Баланс: 0<i class="fa fa-ruble"></i></h6>
                      <p class="card-description text-center">
                        {{ $card->name}}
                      </p>
                    </div>
                    <div class="footer">
                    <a href="" class="btn btn-just-icon btn-facebook btn-round">
                      <div class="ripple-container"></div>
                    </a>
                    </div>
                  </div>
                </div>
           @endforeach
          </div>
        </div>
        <div class="col-md-2 col-md-offset-1 stats">
          <h4 class="title">Stats</h4>
          <ul class="list-unstyled">
            <li><b>60</b> Products</li>
            <li><b>4</b> Collections</li>
            <li><b>331</b> Influencers</li>
            <li><b>1.2K</b> Likes</li>
          </ul>
          <hr>
          <h4 class="title">About his Work</h4>
          <p class="description">French luxury footwear and fashion. The footwear has incorporated shiny, red-lacquered soles that have become his signature.</p>
          <hr>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
@endsection





