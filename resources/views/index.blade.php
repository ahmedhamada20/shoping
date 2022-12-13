<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Movex | Delivery</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/css/vendors.css') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicon/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicon/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicon/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicon/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicon/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicon/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicon/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicon/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/vendor/aos/aos.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/vendor/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/vendor/glightbox/css/glightbox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.css') }}">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/style.css') }}">

    <!-- =======================================================
  * Template Name: Movex - v4.7.0
  * Template URL: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top  header-transparent ">
        <div class="container d-flex align-items-center justify-content-between">

            <div class="logo">
                <h2><a href="index.html"><img src="{{ asset('favicon/favicon-32x32.png') }}" alt="" class="img-fluid"> Movex </a></h2>
                <!-- <h2><a href="#"></a></h1> -->

                <!-- <nav class="navbar navbar-light bg-light">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('favicon/favicon-32x32.png') }}" width="30" height="30" class="d-inline-block align-top" alt="">
                    Movex
                </a> -->
                </nav>

            </div>


            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="{{route('privacy')}}" target="_blank">Privacy Policy</a></li>
                    <li><a class="nav-link scrollto" href="{{route('terms')}}" target="_blank">Terms & Conditions</a></li>
                    <!-- <li><a class="nav-link scrollto" href="#pricing">Pricing</a></li>
          <li><a class="nav-link scrollto" href="#faq">F.A.Q</a></li>
          <li class="dropdown"><a href="#"><span>Drop Down</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> -->
                    <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
                    <li><a class="getstarted scrollto" href="#features">Get Started</a></li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">

        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
                    <div>
                        <h1>Movex Delivery</h1>
                        <h2>Movex Delivery app makes it easy to request package deliveries in the UAE.
                            With our courier partners, whether you want to send small or big packages we got you covered.</h2>
                        <a href="https://play.google.com/store/apps/details?id=com.deli.deligo" target="_blank" class="download-btn"><i class="bx bxl-play-store"></i> Google Play</a>
                        <a href="https://apps.apple.com/us/app/movex-delivery/id1617771710" target="_blank" class="download-btn"><i class="bx bxl-apple"></i> App Store</a>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
                    <img src="{{ asset('frontend/assets/img/movexdeli.png') }}" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section><!-- End Hero -->

    <main id="main">

        <!-- ======= App Features Section ======= -->
        <section id="features" class="features">
            <div class="container">

                <div class="section-title">
                    <h2>App Features</h2>
                    <p>Movex Delivery app has the best shipping solutions for you to ship your parcel within UAE.
                        With customer satisfaction at the core of our services, we assure prompt delivery across cities at a reduced cost.</p>
                </div>

                <div class="row no-gutters">
                    <div class="col-xl-7 d-flex align-items-stretch order-2 order-lg-1">
                        <div class="content d-flex flex-column justify-content-center">
                            <div class="row">
                                <div class="col-md-6 icon-box" data-aos="fade-up">
                                    <i class="bx bx-receipt"></i>
                                    <h4>Delivery across cities within UAE</h4>
                                    <p></p>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="100">
                                    <i class="bx bx-cube-alt"></i>
                                    <h4>Faster Delivery</h4>
                                    <p></p>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="200">
                                    <i class="bx bx-images"></i>
                                    <h4>Secure Packages</h4>
                                    <p></p>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="300">
                                    <i class="bx bx-shield"></i>
                                    <h4>Easy to use App</h4>
                                    <p></p>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="400">
                                    <i class="bx bx-atom"></i>
                                    <h4>Ios & Android Platform</h4>
                                    <p></p>
                                </div>
                                <div class="col-md-6 icon-box" data-aos="fade-up" data-aos-delay="500">
                                    <i class="bx bx-id-card"></i>
                                    <h4>Better user experience</h4>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="image col-xl-5 d-flex align-items-stretch justify-content-center order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
                        <img src="{{ asset('frontend/assets/img/appfeatures.png') }}" class="img-fluid" alt="">
                    </div>
                </div>

            </div>
        </section><!-- End App Features Section -->

        <!-- ======= Details Section ======= -->
        <section id="details" class="details">
            <div class="container">

                <div class="row content">
                    <div class="col-md-4" data-aos="fade-right">
                        <img src="{{ asset('frontend/assets/img/details-1.png') }} " class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-4" data-aos="fade-up">
                        <h3>Delivery across cities within UAE</h3>
                        <p class="fst-italic">
                            Movex Delivery app has the best shipping solutions for you to ship your parcel within UAE.
                            With customer satisfaction at the core of our services, we assure prompt delivery across cities at a reduced cost.
                        </p>
                        <!--<ul>-->
                        <!--    <li><i class="bi bi-check"></i> </li>-->
                        <!--    <li><i class="bi bi-check"></i> </li>-->
                        <!--    <li><i class="bi bi-check"></i></li>-->
                        <!--    <li><i class="bi bi-check"></i></li>-->
                        <!--</ul>-->
                        <p>

                        </p>
                    </div>
                </div>

                <div class="row content">
                    <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                        <img src="{{ asset('frontend/assets/img/fasterdelivery.png') }} " class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                        <h3>Faster Delivery</h3>
                        <p class="fst-italic">
                            Movex Delivery app has the best shipping solutions for you to ship your parcel within UAE.
                            With customer satisfaction at the core of our services, we assure prompt delivery across cities at a reduced cost.
                        </p>
                        <p>

                        </p>
                        <p>
                        </p>
                    </div>
                </div>

                <div class="row content">
                    <div class="col-md-4" data-aos="fade-right">
                        <img src=" {{ asset('frontend/assets/img/details-3.png') }} " class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5" data-aos="fade-up">
                        <h3>Better User Experience</h3>
                        <p>Movex Delivery app has the best shipping solutions for you to ship your parcel within UAE.
                            With customer satisfaction at the core of our services, we assure prompt delivery across cities at a reduced cost.</p>
                        <ul>
                            <li><i class="bi bi-check"></i> Android % IosPlatform.</li>
                            <li><i class="bi bi-check"></i> Faster and secures</li>
                            <!-- <li><i class="bi bi-check"></i> </li> -->
                        </ul>
                        <p>
                            
                        </p>
                        <p>
                           
                        </p>
                    </div>
                </div>

                <div class="row content">
                    <div class="col-md-4 order-1 order-md-2" data-aos="fade-left">
                        <img src=" {{ asset('frontend/assets/img/details-4.png') }} " class="img-fluid" alt="">
                    </div>
                    <div class="col-md-8 pt-5 order-2 order-md-1" data-aos="fade-up">
                        <h3>Secure Packages</h3>
                        <p class="fst-italic">
                        Movex Delivery app has the best shipping solutions for you to ship your parcel within UAE.
                            With customer satisfaction at the core of our services, we assure prompt delivery across cities at a reduced cost.
                        </p>
                        <p>
                           
                        </p>
                        <ul>
                            <!-- <li><i class="bi bi-check"></i> Et praesentium laboriosam architecto nam .</li>
                            <li><i class="bi bi-check"></i> Eius et voluptate. Enim earum tempore aliquid. Nobis et sunt consequatur. Aut repellat in numquam velit quo dignissimos et.</li>
                            <li><i class="bi bi-check"></i> Facilis ut et voluptatem aperiam. Autem soluta ad fugiat.</li> -->
                        </ul>
                    </div>
                </div>

            </div>
        </section><!-- End Details Section -->

        <!-- ======= Gallery Section ======= -->
        <!-- <section id="gallery" class="gallery">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Gallery</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

      </div>

      <div class="container-fluid" data-aos="fade-up">
        <div class="gallery-slider swiper">
          <div class="swiper-wrapper">
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-1.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-1.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-2.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-2.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-3.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-3.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-4.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-4.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-5.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-5.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-6.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-6.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-7.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-7.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-8.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-8.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-9.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-9.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-10.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-10.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-11.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-11.png" class="img-fluid" alt=""></a></div>
            <div class="swiper-slide"><a href="assets/img/gallery/gallery-12.png" class="gallery-lightbox" data-gall="gallery-carousel"><img src="assets/img/gallery/gallery-12.png" class="img-fluid" alt=""></a></div>
          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>
    </section> -->
        <!-- End Gallery Section -->

        <!-- ======= Testimonials Section ======= -->
        <!-- <section id="testimonials" class="testimonials section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Testimonials</h2>
                    <p>Movex Delivery app has the best shipping solutions for you to ship your parcel within UAE.
                        With customer satisfaction at the core of our services, we assure prompt delivery across cities at a reduced cost.</p>
                </div>

                <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{asset('frontend/assets/img/testimonials/testimonials-1.jpg') }}" class="testimonial-img" alt="">
                                <h3>Saul Goodman</h3>
                                <h4>Ceo &amp; Founder</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{asset('frontend/assets/img/testimonials/testimonials-2.jpg') }}" class="testimonial-img" alt="">
                                <h3>Sara Wilsson</h3>
                                <h4>Designer</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{asset('frontend/assets/img/testimonials/testimonials-3.jpg') }}" class="testimonial-img" alt="">
                                <h3>Jena Karlis</h3>
                                <h4>Store Owner</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{asset('frontend/assets/img/testimonials/testimonials-4.jpg') }}" class="testimonial-img" alt="">
                                <h3>Matt Brandon</h3>
                                <h4>Freelancer</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>

                        <div class="swiper-slide">
                            <div class="testimonial-item">
                                <img src="{{asset('frontend/assets/img/testimonials/testimonials-5.jpg') }}" class="testimonial-img" alt="">
                                <h3>John Larson</h3>
                                <h4>Entrepreneur</h4>
                                <p>
                                    <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                    Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.
                                    <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                                </p>
                            </div>
                        </div>

                    </div>
                    <div class="swiper-pagination"></div>
                </div>

            </div>
        </section> -->
        <!-- End Testimonials Section -->

        <!-- ======= Pricing Section ======= -->
        <!-- <section id="pricing" class="pricing">
      <div class="container">

        <div class="section-title">
          <h2>Pricing</h2>
          <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
        </div>

        <div class="row no-gutters">

          <div class="col-lg-4 box" data-aos="fade-right">
            <h3>Free</h3>
            <h4>$0<span>per month</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
              <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
              <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
              <li class="na"><i class="bx bx-x"></i> <span>Pharetra massa massa ultricies</span></li>
              <li class="na"><i class="bx bx-x"></i> <span>Massa ultricies mi quis hendrerit</span></li>
            </ul>
            <a href="#" class="get-started-btn">Get Started</a>
          </div>

          <div class="col-lg-4 box featured" data-aos="fade-up">
            <h3>Business</h3>
            <h4>$29<span>per month</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
              <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
              <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
              <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
              <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
            </ul>
            <a href="#" class="get-started-btn">Get Started</a>
          </div>

          <div class="col-lg-4 box" data-aos="fade-left">
            <h3>Developer</h3>
            <h4>$49<span>per month</span></h4>
            <ul>
              <li><i class="bx bx-check"></i> Quam adipiscing vitae proin</li>
              <li><i class="bx bx-check"></i> Nec feugiat nisl pretium</li>
              <li><i class="bx bx-check"></i> Nulla at volutpat diam uteera</li>
              <li><i class="bx bx-check"></i> Pharetra massa massa ultricies</li>
              <li><i class="bx bx-check"></i> Massa ultricies mi quis hendrerit</li>
            </ul>
            <a href="#" class="get-started-btn">Get Started</a>
          </div>

        </div>

      </div>
    </section>End Pricing Section -->

        <!-- ======= Frequently Asked Questions Section ======= -->
        <!-- <section id="faq" class="faq section-bg">
            <div class="container" data-aos="fade-up">

                <div class="section-title">

                    <h2>Frequently Asked Questions</h2>
                    <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
                </div>

                <div class="accordion-list">
                    <ul>
                        <li data-aos="fade-up">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1">Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                            <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                                <p>
                                    Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="100">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed">Feugiat scelerisque varius morbi enim nunc? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                            <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                                <p>
                                    Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="200">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed">Dolor sit amet consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                            <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                                <p>
                                    Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="300">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-4" class="collapsed">Tempus quam pellentesque nec nam aliquam sem et tortor consequat? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                            <div id="accordion-list-4" class="collapse" data-bs-parent=".accordion-list">
                                <p>
                                    Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in.
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="400">
                            <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" data-bs-target="#accordion-list-5" class="collapsed">Tortor vitae purus faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                            <div id="accordion-list-5" class="collapse" data-bs-parent=".accordion-list">
                                <p>
                                    Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque.
                                </p>
                            </div>
                        </li>

                    </ul>
                </div>

            </div>
        </section> -->
        <!-- End Frequently Asked Questions Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">

                <div class="section-title">
                    <h2>Contact</h2>
                    <p>Movex Delivery app has the best shipping solutions for you to ship your parcel within UAE.
                        With customer satisfaction at the core of our services, we assure prompt delivery across cities at a reduced cost.</p>
                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-lg-6 info">
                                <i class="bx bx-map"></i>
                                <h4>Address</h4>
                                <p>Al AIN, Al Maqam<br>Abu Dhabi</p>
                            </div>
                            <div class="col-lg-6 info">
                                <i class="bx bx-phone"></i>
                                <h4>Call Us</h4>
                                <p>+971 50 600 2040</p>
                            </div>
                            <div class="col-lg-6 info">
                                <i class="bx bx-envelope"></i>
                                <h4>Email Us</h4>
                                <p>info@movex.ae</p>
                            </div>
                            <div class="col-lg-6 info">
                                <i class="bx bx-time-five"></i>
                                <h4>Working Hours</h4>
                                <p>Mon - Fri: 12PM to 9PM</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <form action="" method="" role="form" class="php-email-form" data-aos="fade-up">
                            <div class="form-group">
                                <input placeholder="Your Name" type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="form-group mt-3">
                                <input placeholder="Your Email" type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group mt-3">
                                <input placeholder="Subject" type="text" class="form-control" name="subject" id="subject" required>
                            </div>
                            <div class="form-group mt-3">
                                <textarea placeholder="Message" class="form-control" name="message" rows="5" required></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>
                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h4>Join Our Newsletter</h4>
                        <p>Movex Delivery app makes it easy to request package deliveries in the UAE. </p>
                        <form action="" method="">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>Movex</h3>
                        <p>
                            Al AIN, Al Maqam<br>
                            Abu Dhabi<br>
                            UAE <br><br>
                            <strong>Phone:</strong> +971 50 600 2040<br>
                            <strong>Email:</strong> info@movex.ae<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
                            <!-- <li><i class="bx bx-chevron-right"></i> <a href="#">About us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Services</a></li> -->
                            <li><i class="bx bx-chevron-right"></i> <a href="{{route('terms')}}" target="_blank">Terms of service</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="{{route('privacy')}}" target="_blank">Privacy policy</a></li>
                        </ul>
                    </div>

                    <!-- <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div> -->

                    <!--<div class="col-lg-3 col-md-6 footer-links">-->
                    <!--    <h4>Our Social Networks</h4>-->
                    <!--    <p></p>-->
                    <!--    <div class="social-links mt-3">-->
                    <!--        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>-->
                    <!--        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>-->
                    <!--        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>-->
                    <!--        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>-->
                    <!--        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>-->
                    <!--    </div>-->
                    <!--</div>-->

                </div>
            </div>
        </div>

        <div class="container py-4">
            <div class="copyright">
                &copy; Copyright <strong><span>Movex Delivery</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/free-bootstrap-app-landing-page-template/ -->
                <!-- Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> -->
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('frontend/assets/vendor/php-email-form/validate.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>

</body>

</html>