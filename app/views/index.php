<?php require __DIR__."/header.php"; ?>


<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">
                    <i class="fa fa-play-circle"></i> <span class="light">TinyMe</span> Framework
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#download">Download</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <h1 class="brand-heading">TinyMe</h1>
                        <p class="intro-text">A tiny php framework based on flight and medoo.
                            <br>Created by <a href="https://github.com/ycrao">ycrao</a>.</p>
                        <a href="#about" class="btn btn-circle page-scroll">
                            <i class="fa fa-angle-double-down animated"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- About Section -->
    <section id="about" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>About TinyMe</h2>
                <p>A tiny php framework based on flight and medoo. <code>TinyMe</code> using third-party components, you can get help from their offical website. </p>
                <p>Its kernel based on <code>mikecao/flight</code> , official website : <a href="https://flightphp.com/">https://flightphp.com/</a> , <a href="https://github.com/mikecao/flight">https://github.com/mikecao/flight</a> .</p>
                <p>DB based on <code>catfan/medoo</code> , official website : <a href="https://github.com/catfan/medoo">https://github.com/catfan/medoo</a> , <a href="https://medoo.in/doc">https://medoo.in/doc</a> .</p>
            </div>
        </div>
    </section>

    <!-- Download Section -->
    <section id="download" class="content-section text-center">
        <div class="download-section">
            <div class="container">
                <div class="col-lg-8 col-lg-offset-2">
                    <h2>Download TinyMe</h2>
                    <p>You can download TinyMe for free on <a href="https://github.com/ycrao/tinyme">GitHub</a>.</p>
                    <a href="https://github.com/ycrao/tinyme/archive/master.zip" class="btn btn-default btn-lg">Visit Download Page</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="container content-section text-center">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <h2>Contact TinyMe</h2>
                <p>Feel free to email us to provide some feedback on our software, give us suggestions for new software and service, or to just say hello!</p>
                <p><a href="mailto:raoyc2009@gmail.com">raoyc2009@gmail.com</a>
                </p>
                <ul class="list-inline banner-social-buttons">
                    <li>
                        <a href="https://github.com/ycrao/tinyme" class="btn btn-default btn-lg"><i class="fa fa-github fa-fw"></i> <span class="network-name">Github</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </section>

<?php require __DIR__."/footer.php"; ?>
