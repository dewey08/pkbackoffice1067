@extends('layouts.fontend')
@section('title', 'PK-OFFICE || Fontend')
 
@section('content')
 
    <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{	
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
               }
               .cv-spinner {
               height: 100%;
               display: flex;
               justify-content: center;
               align-items: center;  
               }
               .spinner {
               width: 250px;
               height: 250px;
               border: 10px #ddd solid;
               border-top: 10px #1fdab1 solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% { 
                   transform: rotate(390deg); 
               }
               }
               .is-hide{
               display:none;
               }
    </style>
    
 <div class="container-fluid p-5"> 
  
            <div class="row"> 
                <div class="col-md-4">
                    <h4 class="card-title" style="color:rgb(10, 151, 85)">Detail CCTV</h4>
                    <p class="card-title-desc">รายละเอียดกล้องวงจรปิด</p>
                </div>
                <div class="col"></div>
            </div>  
            
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card_prs_4">
                        <div class="card-body">    
                           
                            <p class="mb-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                
                                    </table>
                                </div>
                            </p>

                        </div>
                    </div>
                </div>
            </div>
 
 
    </div>
  

    @endsection
    @section('footer')
    
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

           
        });
    </script>
    @endsection
