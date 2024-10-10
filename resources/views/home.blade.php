@extends('layouts.app')

@section('title', 'Flavora - Home')

@section('content')
    <!-- Slider -->
    @include('partials.slider')

    <!-- Popular Recipes -->
    <section class="recipe_section layout_padding-top">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
        Resep Populer Terbaik Kami
        </h2>
      </div>
      <div class="row">
        <div class="col-sm-6 col-md-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="delfood-1.0.0/images/r1.jpg" class="box-img" alt="">
            </div>
            <div class="detail-box">
              <h4>
                Breakfast
              </h4>
              <a href="recipes">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="delfood-1.0.0/images/r2.jpg" class="box-img" alt="">
            </div>
            <div class="detail-box">
              <h4>
                Lunch
              </h4>
              <a href="recipes">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 mx-auto">
          <div class="box">
            <div class="img-box">
              <img src="delfood-1.0.0/images/r3.jpg" class="box-img" alt="">
            </div>
            <div class="detail-box">
              <h4>
                Dinner
              </h4>
              <a href="recipes">
                <i class="fa fa-arrow-right" aria-hidden="true"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

    <!-- Blog Section -->
    <section class="news_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>Resep Terbaru</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="box">
                        <div class="img-box">
                            <img src="{{ asset('delfood-1.0.0/images/n1.jpg') }}" class="box-img" alt="Tasty Food For You">
                        </div>
                        <div class="detail-box">
                            <h4>Tasty Food For You</h4>
                            <p>There isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined.</p>
                            <a href="recipes">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box">
                        <div class="img-box">
                            <img src="{{ asset('delfood-1.0.0/images/n2.jpg') }}" class="box-img" alt="Breakfast For You">
                        </div>
                        <div class="detail-box">
                            <h4>Breakfast For You</h4>
                            <p>There isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined.</p>
                            <a href="recipes">
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection