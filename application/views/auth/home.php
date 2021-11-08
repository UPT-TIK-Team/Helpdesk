<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="generator" content="Hugo 0.48" />
  <meta charset="utf-8">
  <meta name="robots" content="index, follow">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Dev Space by Lapa Ninja</title>
  <meta name="keywords" content="yeo">
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,400,700" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/spectre.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/spectre-icons.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/spectre-exp.css">
  <link rel="stylesheet" href="<?= base_url() ?>assets/css/yeo.css">
  <meta property="og:title" content="">
  <meta property="og:url" content="">
  <meta property="og:description" content="">
  <meta property="og:site_name" content="">
  <meta property="og:type" content="product">
  <meta property="og:image" content="">
  <link rel="shortcut icon" href="<?= base_url() ?>assets/images/landing-page/favicon.ico">
</head>

<body>
  <div class="yeo-slogan">
    <div class="container yeo-header">
      <div class="columns">
        <div class="column col-12">
          <header class="navbar">
            <section class="navbar-section">
              <a class="navbar-brand logo" href="./">
                <img class="logo-img" src="<?= base_url() ?>assets/images/landing-page/Tik Logo.svg" alt=""><span>Helpdesk UNSIKA</span>
              </a>
            </section>
            <section class="navbar-section hide-sm">
              <a class="btn btn-link" href="#we-do">Beranda</a>
              <!-- <a class="btn btn-link" href="#we-work">How we work</a> -->
              <!-- <a class="btn btn-link" href="#price">Pricing</a> -->
              <!-- <a class="btn btn-link" href="#team">Tim Kami</a> -->
              <a class="btn btn-primary btn-hire-me" href="<?= base_url('auth/login') ?>">Masuk</a>
            </section>
          </header>
        </div>
      </div>
    </div>
    <div class="container slogan">
      <div class="columns">
        <div class="column col-7 col-sm-12">
          <div class="slogan-content">
            <h1>
              <span class="slogan-bold">Halo</span>
              <span class="slogan-bold">Selamat Datang</span>
              <!-- <span class="slogan-bold" style="font-size: 45px;">Ada Yang bisa Kami Bantu ? </span> -->
            </h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
            <a class="btn btn-primary btn-lg btn-start" target="_blank" href="<?= base_url('auth/login') ?>">Buat Tiket</a>

          </div>
        </div>
        <div class="column col-5 hide-sm">
          <img class="slogan-img" src="<?= base_url() ?>assets/images/landing-page/yeo-feature-1.svg" alt="">
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="yeo-client">
            <div class="container yeo-client-list">
                <div class="columns">
                    <div class="column col-12">
                        <h3 class="feature-title">
                        Trusted By The Best Clients
                    </h3>
                        <div class="client-logo">
                            <a href="#" target="_blank">
                            <img src="<?= base_url() ?>assets/images/landing-page/algolia.svg" height="40px" alt="">
                        </a>
                            <a href="#" target="_blank">
                            <img src="<?= base_url() ?>assets/images/landing-page/lapa-logo.svg" height="40px" alt="">
                        </a>
                            <a href="#" target="_blank">
                            <img src="<?= base_url() ?>assets/images/landing-page/hugo.svg" height="40px" alt="">
                        </a>
                            <a href="#" target="_blank">
                            <img src="<?= base_url() ?>assets/images/landing-page/codecademy.svg" height="40px" alt="">
                        </a>
                            <a href="#" target="_blank">
                            <img src="<?= base_url() ?>assets/images/landing-page/aws.svg" height="40px" alt="">
                        </a>
                            <a href="#" target="_blank">
                            <img src="<?= base_url() ?>assets/images/landing-page/stripe.svg" height="40px" alt="">
                        </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
  <div class="yeo-do" id="we-do">
    <div class="container yeo-body">
      <div class="columns">
        <div class="column col-12">
          <h2 class="feature-title">Layanan Helpdesk</h2>
        </div>
        <div class="column col-4 col-sm-12">
          <div class="yeo-do-content">
            <img src="<?= base_url() ?>assets/images/landing-page/server.png" alt="">
            <h3>Data Center</h3>
            <p>Menyediakan fasilitas untuk menampung kebutuhan akan penyimpanan data seperti (hosting, Instalasi server) pada lingkungan UNSIKA</p>
            <a href="">Learn more</a>
          </div>
        </div>
        <div class="column col-4 col-sm-12">
          <div class="yeo-do-content">
            <img src="<?= base_url() ?>assets/images/landing-page/what-we-do-2.svg" alt="">
            <h3>Event Support</h3>
            <p>Membantu event yang ada di UNSIKA pada kegiatan pimpinan atau kegiatan khusus</p>
            <a href="">Learn more</a>
          </div>
        </div>
        <div class="column col-4 col-sm-12">
          <div class="yeo-do-content">
            <img src="<?= base_url() ?>assets/images/landing-page/network.png" alt="">
            <h3>Jaringan</h3>
            <p>Kami siap melayani permintaan jaringan di UNSIKA seperti troubleshooting jaringan, penambahan bandwidth untuk keperluan tertentu</p>
            <a href="">Learn more</a>
          </div>
        </div>
        <div class="column col-4 col-sm-12">
          <div class="yeo-do-content">
            <img src="<?= base_url() ?>assets/images/landing-page/what-we-do-3.svg" alt="">
            <h3>Layanan Aplikasi</h3>
            <p>Melayani permintaan akan kebutuhan aplikasi seperti pembuatan website ataupun aplikasi seluler, maintenance aplikasi di linkungan UNSIKA (eCampus, Sikeu, epresence, Email UNSIKA, eVika, Learning Management System, LabSyska, Sister, SIAKADTIK ) </p>
            <a href="">Learn more</a>
          </div>
        </div>
        <div class="column col-4 col-sm-12">
          <div class="yeo-do-content">
            <img src="<?= base_url() ?>assets/images/landing-page/career.png" alt="">
            <h3>Layanan Digitalisasi Bisnis</h3>
            <p>Melayani permintaan akan kebutuhan digitalisasi pada lingkungan UNSIKA </p>
            <a href="">Learn more</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="yeo-work" id="we-work">
    <div class="container yeo-body">
      <div class="columns">
        <div class="column col-12 col-sm-12">
          <h2 class="feature-title">Ajukan Pertanyaan</h2>
        </div>
        <div class="column col-10 col-sm-12 centered">
          <h2 class="yeo-work-feature">
            Kami akan <span class="yeo-work-feature-bold">secepat mungkin </span>menyelesaikan masalah anda.
          </h2>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="yeo-price" id="price">
            <div class="container yeo-body  col-sm-12">
                <div class="columns">
                    <div class="column col-4 col-sm-12">
                        <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title"><span>PRO</span></div>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <span class="price">$2500 </span>
                                    <span>/ month</span>
                                </p>
                                <ul>
                                    <li><strong>10</strong> billable hours included per month.</li>
                                    <li>Billable hourly rate of <strong>$300</strong> after the included 10 hours are utilized.</li>
                                    <li>24/7/365 on-call and 99.9% SLA</li>
                                    <li>Communication via ticketing system and e-mail.</li>
                                </ul>
                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-primary btn-price">Contact Us</button>
                            </div>
                        </div>
                    </div>
                    <div class="column col-4 col-sm-12">
                        <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title"><span>PREMIUM</span></div>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <span class="price">$5000 </span>
                                    <span>/ month</span>
                                </p>
                                <ul>
                                    <li><strong>10</strong> billable hours included per month.</li>
                                    <li>Billable hourly rate of <strong>$300</strong> after the included 10 hours are utilized.</li>
                                    <li>24/7/365 on-call and 99.9% SLA</li>
                                    <li>Communication via ticketing system and e-mail.</li>
                                </ul>
                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-primary btn-price">Contact Us</button>
                            </div>
                        </div>
                    </div>
                    <div class="column col-4 col-sm-12">
                        <div class="panel">
                            <div class="panel-header">
                                <div class="panel-title"><span>ENTERPRISE</span></div>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <span class="price">$15000 </span>
                                    <span>/ month</span>
                                </p>
                                <ul>
                                    <li><strong>10</strong> billable hours included per month.</li>
                                    <li>Billable hourly rate of <strong>$300</strong> after the included 10 hours are utilized.</li>
                                    <li>24/7/365 on-call and 99.9% SLA</li>
                                    <li>Communication via ticketing system and e-mail.</li>
                                </ul>
                            </div>
                            <div class="panel-footer">
                                <button class="btn btn-primary btn-price">Contact Us</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
  <!-- <div class="yeo-team" id="team">
            <div class="container yeo-body">
                <div class="columns">
                    <div class="column col-12">
                        <h2 class="feature-title">Tentang Kami</h2>
                    </div>
                    <div class="column col-4 col-sm-12">
                        <a href=""><img class="s-circle" src="<?= base_url() ?>assets/images/landing-page/team-1.jpg" alt=""></a>
                        <a href="https://www.lapa.ninja/"><span class="name">John Doe</span></a>
                        <span class="title">DevOps</span>
                    </div>
                    <div class="column col-4 col-sm-12">
                        <a href=""><img class="s-circle" src="<?= base_url() ?>assets/images/landing-page/team-2.jpg" alt=""></a>
                        <a href="https://www.lapa.ninja/"><span class="name">Tinh Nguyen</span></a>
                        <span class="title">Designer</span>
                    </div>
                    <div class="column col-4 col-sm-12">
                        <a href=""><img class="s-circle" src="<?= base_url() ?>assets/images/landing-page/team-3.jpg" alt=""></a>
                        <a href="https://www.lapa.ninja/"><span class="name">Maria Oto</span></a>
                        <span class="title">Developer</span>
                    </div>
                </div>
            </div>
        </div> -->
  <div class="yeo-open-source">
    <div class="container yeo-body">
      <div class="columns">
        <div class="column col-12">
          <h2 class="feature-title">We love Unsika</h2>
        </div>
        <div class="column col-10 centered col-sm-12">
          <img class="open-source-img" src="<?= base_url() ?>assets/images/landing-page/open-source.svg" alt="">
          <h2 class="open-source-feature">
            We're making
            <br />
            UNSIKA be Better
          </h2>
          <!-- <a href="#" class="btn btn-lg btn-open-source">Follow us on Github</a> -->
        </div>
      </div>
    </div>
  </div>
  <div class="yeo-footer">
    <div class="container">
      <div class="columns">
        <div class="column col-4 col-sm-6">
          <!-- <div class="yeo-footer-content">
                            <h4>Contact Us</h4>
                            <ul class="nav">
                                <li class="nav-item">
                                    <a href="https://www.lapa.ninja/">tinh@lapa.ninja</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.lapa.ninja/">Twitter</a>
                                </li>
                                <li class="nav-item">
                                    <a href="https://www.lapa.ninja/">Github</a>
                                </li>
                            </ul>
                        </div> -->
        </div>
        <div class="column col-4 col-sm-6">
          <div class="yeo-footer-content">
            <h4 style="text-align: center;">Copyright</h4>
            <ul class="nav">
              <li class="nav-item">
                <a href="uo">
                  <img src="https://upttik.unsika.ac.id/wp-content/uploads/2020/08/tikupt.png" alt="" srcset="">
                </a>
              </li>

            </ul>
          </div>
        </div>
        <div class="column col-4 col-sm-6">

        </div>

      </div>
    </div>
  </div>
</body>

</html>