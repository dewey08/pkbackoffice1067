 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QrCode All</title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style>
    @page {
        margin: 40px;
        margin-bottom: 1px;
        margin-left: 15px;
        margin-right: 15px;
    }

    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px; 
    }

 
</style>
<?php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
?>

<body>
 
    <body onload="window.print()"> 
        <div class="container">
            <div class="row mt-4">

               
                        <?php $i = 0; ?>
                        @foreach ($dataprint as $key => $item)
                        <?php $i++; ?>
                            <div class="col-md-2 text-center mt-4">
                                <div class="card mb-5 mt-5"
                                    style="max-width: 25rem;border-color:rgb(193, 20, 236);background-color:rgb(218, 250, 248);border-radius: 2em 2em 2em 2em">
                                    <div class="body"><br>
                                        {!! QrCode::size(112)->style('round')->generate('http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/drinking_check_add/' . $item->water_filter_id) !!}
                                        <hr style="color:rgb(193, 20, 236)">
                                        <p style="font-size: 17px;color:rgb(193, 20, 236)"> {{ $item->water_code }} <br>
                                            สแกนเพื่อตรวจสอบ</p>
                                    </div>
                                </div>
                            </div> 
                        @endforeach
 
                      
            </div>
            
        </div>  

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
            integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
            integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
        </script>
    </body>

</html>

        
                     
