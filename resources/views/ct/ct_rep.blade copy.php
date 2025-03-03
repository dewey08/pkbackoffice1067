<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/dstyle.css') }}" type="text/css">
    {{-- <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet"> --}}
    <title></title>
</head>

<body>

    <section>

        <div class="left-div">
            <br>
            <h2 class="logo">M -<span style="font-weight: 100; "> SoftTech</span></h2>
            <hr class="hr" />
            <ul class="nav">
                <li><a href=""><i class="fa fa-th-large"></i> Home</a></li>
                <li><a href=""><i class="fa fa-user"></i> User Control</a></li>
                <li class="active"><a href=""><i class="fa fa-key"></i> Access Request</a></li>
                <li><a href=""><i class="fa fa-desktop"></i> Admin</a></li>
                <li><a href=""><i class="fa fa-gear"></i> Settings</a></li>
                <li><a href=""><i class="fa fa-bullhorn"></i> Support</a></li>
                <li><a href=""><i class="fa fa-power-off"></i> Quit</a></li>
            </ul>
            <br><br>
            {{-- <img src="image/s.png" class="support"> --}}
        </div>

        <div class="right-div"> 

            {{-- <div id="main">
                <br>
                <div class="head">
                    <div class="col-div-6">
                        <p class="nav"> Dashboard</p>
                    </div>

                    <div class="col-div-6">


                        <div class="profile">

                            <img src="image/user.png" class="pro-img" />
                            <p>Manoj Adhikari <i class="fa fa-ellipsis-v dots" aria-hidden="true"></i></p>
                            <div class="profile-div">
                                <p><i class="fa fa-user"></i> Profile</p>
                                <p><i class="fa fa-cogs"></i> Settings</p>
                                <p><i class="fa fa-power-off"></i> Log Out</p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
                <br /><br /><br />

                <div class="col-div-4-1">
                    <div class="box">
                        <p class="head-1">Sales</p>
                        <p class="number">67343</p>
                        <p class="percent"><i class="fa fa-long-arrow-up" aria-hidden="true"></i> 5.674% <span>Since
                                Last Months</span></p>
                        <i class="fa fa-line-chart box-icon"></i>
                    </div>
                </div>
                <div class="col-div-4-1">
                    <div class="box">
                        <p class="head-1">purchases</p>
                        <p class="number">2343</p>
                        <p class="percent" style="color:red!important"><i class="fa fa-long-arrow-down"
                                aria-hidden="true"></i> 5.64% <span>Since Last Months</span></p>
                        <i class="fa fa-circle-o-notch box-icon"></i>
                    </div>
                </div>
                <div class="col-div-4-1">
                    <div class="box">
                        <p class="head-1">orders</p>
                        <p class="number">35343</p>
                        <p class="percent"><i class="fa fa-long-arrow-up" aria-hidden="true"></i> 5.674% <span>Since
                                Last Months</span></p>
                        <i class="fa fa-shopping-bag box-icon"></i>
                    </div>
                </div>

                <div class="clearfix"></div>
                <br /><br />


                <div class="col-div-4-1">
                    <div class="box-1">
                        <div class="content-box-1">
                            <p class="head-1">Overview</p>
                            <br />
                            <div class="m-box active1">
                                <p>Member Profit<br /><span class="no-1">Last Months</span></p>
                                <span class="no">+2343</span>
                            </div>

                            <div class="m-box">
                                <p>Member Profit<br /><span class="no-1">Last Months</span></p>
                                <span class="no">+2343</span>
                            </div>

                            <div class="m-box">
                                <p>Member Profit<br /><span class="no-1">Last Months</span></p>
                                <span class="no">+2343</span>
                            </div>

                            <div class="m-box">
                                <p>Member Profit<br /><span class="no-1">Last Months</span></p>
                                <span class="no">+2343</span>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-div-4-1">
                    <div class="box-1">
                        <div class="content-box-1">
                            <p class="head-1">Total Sale <span>View All</span></p>

                            <div class="circle-wrap">
                                <div class="circle">
                                    <div class="mask full">
                                        <div class="fill"></div>
                                    </div>
                                    <div class="mask half">
                                        <div class="fill"></div>
                                    </div>
                                    <div class="inside-circle"> 70% </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-div-4-1">
                    <div class="box-1">
                        <div class="content-box-1">
                            <p class="head-1">Acitivity <span>View All</span></p>
                            <br />
                            <p class="act-p"><i class="fa fa-circle"></i> Lorem Ipsum is simply dummy text of the
                                printing and typesetting industry. </p>
                            <p class="act-p"><i class="fa fa-circle" style="color:red!important;"></i> Lorem Ipsum
                                is simply dummy text of the printing and typesetting industry. </p>
                            <p class="act-p"><i class="fa fa-circle" style="color:green!important;"></i> Lorem Ipsum
                                is simply dummy text of the printing and typesetting industry. </p>
                            <p class="act-p"><i class="fa fa-circle"></i> Lorem Ipsum is simply dummy text of the
                                printing and typesetting industry. </p>

                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div> --}}

        </div>

        <div class="clearfix"></div>
    </section>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".profile p").click(function() {
                $(".profile-div").toggle();

            });
            $(".noti-icon").click(function() {
                $(".notification-div").toggle();
            });
        });
    </script>
    <script type="text/javascript">
        $('li').click(function() {
            $('li').removeClass("active");
            $(this).addClass("active");
        });
    </script>
</body>

</html>
