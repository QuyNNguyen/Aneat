<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <link rel="stylesheet" href="index.css">

     <!-- Googlefont -->
     <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">


    <title>Kết Quả | ĂnEat</title>
  </head>
    <body>
        <!-- Facebooksheeee -->
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v3.3"></script>

        <nav class="navbar navbar-expand-lg navbar-light navbar-custom" style="background-color: #A8D0E6; font-family: 'Roboto'; color: #FFFFFF;">
          <a class="navbar-brand" href="../">
            <img src="https://i.ibb.co/vzKcn0r/logo-offical.png"border="0" alt="ĂnEat">
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" href="../">Máy Tính Menu</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="./index.html">Máy Tính Calo</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../tailieu">Tài Liệu</a>
              </li>
            </ul>
          </div>
        </nav> 




        <!-- PHP calculations -->

        <?php 

        $sexbonus = 5;
        $hamwisexbonus = [48, 1.06];
        $devinesexbonus = [50, 0.9];
        $millersexbonus = [56.2, 0.55]; 
        $robinsonsexbonus = [52, 0.74]; 

        if ($_GET['sex'] == "female"){
            $sexbonus = -161; 
            $hamwisexbonus = [45,0.86];
            $devinesexbonus = [45.5, 0.9];
            $millersexbonus = [53.1, 0.53];
            $robinsonsexbonus = [49, 0.66];  
        }


        // basic stats
        $BMR = round(10*$_GET['weight'] + 6.25*$_GET['height'] - 5*$_GET['age'] + $sexbonus);

        $BMI = round($_GET['weight'] / ($_GET['height'] * $_GET['height']*0.0001), 1); 

        if ($BMI < 18.5) {
            $BMItype = "thiếu cân";
        } elseif ($BMI >= 18.5 and $BMI <= 24.9) {
            $BMItype = "vừa cân :)";
        } elseif ($BMI >= 25 and $BMI <= 29) {
            $BMItype = "thừa cân";
        } elseif ($BMI >= 30 and $BMI <= 35) {
            $BMItype = "béo phì :(";
        } 
        else {
            $BMItype = "béo phì nặng ;(";
        }

        // ideal weight calculation
        $hamwi = round($hamwisexbonus[0] + ($_GET['height'] - 152.4)* $hamwisexbonus[1]);
        $devine = round($devinesexbonus[0] + ($_GET['height'] - 152.4)* $devinesexbonus[1]);
        $miller = round($millersexbonus[0] + ($_GET['height'] - 152.4)* $millersexbonus[1]);
        $robinson = round($robinsonsexbonus[0] + ($_GET['height'] - 152.4)* $robinsonsexbonus[1]);

        // diet calculation
        $sedentarycalo = round($BMR*1.2);
        $sedentaryprotein = round($sedentarycalo * 0.4 / 4);
        $sedentaryfat = round($sedentarycalo * 0.4 / 9);
        $sedentarycarb = round($sedentarycalo * 0.2 / 4);


        $loosecalo = $sedentarycalo - 500;
        $looseprotein = round($loosecalo * 0.4 / 4);
        $loosefat = round($loosecalo * 0.4 / 9);
        $loosecarb = round($loosecalo * 0.2 / 4);


        $gaincalo = $sedentarycalo + 500;
        $gainprotein = round($gaincalo * 0.4 / 4);
        $gainfat = round($gaincalo * 0.4 / 9);
        $gaincarb = round($gaincalo * 0.2 / 4);


        ?>




        <div class="container-fluid" style="background: #FAFAFA;">
            <div class="col-lg-8 offset-lg-2" style="border-style: solid; border-width: 1px; border-radius: 5px; border-color: #e5e3e3; background:#FFFFFF; margin-top: 10px; padding: 20px 20px 20px 20px;" > 
                <div class="row">
                    <div class="col-md-3">
                        <p style="font-weight: 600; letter-spacing: 1px; font-size: 24px;"> Chỉ số của bạn  </p>
                    </div>
                    <div class="col-md-4">
                        <!-- Facebookstuff -->
                        <div class="fb-like" data-href="http://aneat.fit" data-width="" data-layout="button" data-action="recommend" data-size="small" data-show-faces="true" data-share="true"></div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4" style="text-align: center;"> 
                        <p style="font-weight: 600; letter-spacing: 1px;"> Bạn tiêu hao </p>
                        <div style="border-style: solid; border-width: 2px; border-radius: 20px; border-color: #9bc3d9; background:#A8D0E6; color:#2D3B6E;">
                            <p style="padding: 30px 30px 0 30px; font-weight: 700; font-size: 40px;"> <?php  echo $BMR; ?> </p>
                            <p style="padding: 0 30px 10px 30px; font-style: italic; font-size: 13px;"> calories mỗi ngày </p>
                            <hr>
                            <p style="padding: 10px 30px 0 30px; font-weight: 700; font-size: 40px;"> <?php  echo $BMR*7; ?> </p>
                            <p style="padding: 0 30px 10px 30px; font-style: italic; font-size: 13px;"> calories mỗi tuần </p>
                        </div>

                        <p style=" margin-top: 10px; font-size:17px; font-weight:600;"> Chỉ Số BMI: <?php  echo $BMI; ?></p>
                        <p style="font-size:14px;"> Chỉ số BMI của bạn được coi là <?php  echo $BMItype; ?></p>

                    </div>

                    <div class="col-md-8"> 
                        <p> Máy tính sử dụng công thức <span style="font-weight: bold;">Mifflin-St Jeor</span>. Công thức chính xác nhất dựa vào tuổi, giới tính, cân nặng, và chiều cao. Basal Metabolic Rate (BMR) là số năng lượng tiêu tốn kể cả bạn ngủ cả ngày mà ko hoạt động. Hoạt động ít bao gồm dân văn phòng. Thể dục vừa là tập 1-2 lần/tuần. Thể dục thường xuyên (3-5 lần). Thể dục nhiều (6-7 lần). Vận động viên (2 lần/ngày) </p>
                        <p>Giảm cân hãy  -500 calories, tăng cân hãy +500 calories</p>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        BMR 
                                    </td>
                                    <td>    
                                        <?php  echo $BMR; ?> calories mỗi ngày
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Hoạt động ít
                                    </td>
                                    <td>    
                                        <?php  echo $sedentarycalo; ?> calories mỗi ngày
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Thể dục vừa
                                    </td>
                                    <td>    
                                        <?php  echo round($BMR*1.375); ?> calories mỗi ngày
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Thể dục thường xuyên
                                    </td>
                                    <td>    
                                        <?php  echo round($BMR*1.55); ?> calories mỗi ngày
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Thể dục nhiều
                                    </td>
                                    <td>    
                                        <?php  echo round($BMR*1.725); ?> calories mỗi ngày
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Vận động viên
                                    </td>
                                    <td>    
                                        <?php  echo round($BMR*1.9); ?> calories mỗi ngày
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <p style=" margin-top: 20px; font-size:20px; font-weight:600;"> Cân tiêu chuẩn: <?php  echo min($hamwi, $devine, $robinson, $miller) . "-" . max($hamwi, $devine, $robinson, $miller); ?> kg </p>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        Công thức G.J. Hamwi (1964)
                                    </td>
                                    <td>    
                                        <?php  echo $hamwi; ?> kg
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Công thức B.J. Devine (1974)
                                    </td>
                                    <td>    
                                       <?php  echo $devine; ?> kg
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Công thức J.D. Robinson (1983)
                                    </td>
                                    <td>    
                                        <?php  echo $robinson; ?> kg
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Công thức D.R. Miller (1983)
                                    </td>
                                    <td>    
                                        <?php  echo $miller; ?> kg
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            <div class="row">
                <div class="col-md-12"> 
                <p style=" margin-top: 20px; font-size:20px; font-weight:600;"> Gợi Ý Chế Độ Ăn Tăng Giảm Theo Cal </p>
                <p> Cho Dân Văn Phòng. Dinh dưỡng được tính theo tỉ lệ 40% đạm - 40% mỡ - 20% tinh bột</p>
                </div>
            </div>

            <div class="row" style="margin-top:20px;">
                <div class="col-md-4" style="text-align: center;"> 
                    <p style="font-weight: 600; letter-spacing: 1px;"> Giữ cân </p>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    Tổng calo
                                </td>
                                <td>    
                                    <?php  echo $sedentarycalo; ?>cal
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Protein
                                </td>
                                <td>    
                                    <?php  echo $sedentaryprotein; ?>g
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Mỡ
                                </td>
                                <td>    
                                    <?php  echo $sedentaryfat; ?>g
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Carb
                                </td>
                                <td>    
                                    <?php  echo $sedentarycarb; ?>g
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-4" style="text-align: center;"> 
                    <p style="font-weight: 600; letter-spacing: 1px;"> Giảm cân </p>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    Tổng calo
                                </td>
                                <td>    
                                    <?php  echo $loosecalo; ?>cal
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Protein
                                </td>
                                <td>    
                                    <?php  echo $looseprotein; ?>g
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Mỡ
                                </td>
                                <td>    
                                    <?php  echo $loosefat; ?>g
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Carb
                                </td>
                                <td>    
                                    <?php  echo $loosecarb; ?>g
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-4" style="text-align: center;"> 
                    <p style="font-weight: 600; letter-spacing: 1px;"> Tăng cân </p>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    Tổng calo
                                </td>
                                <td>    
                                    <?php  echo $gaincalo; ?>cal
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Protein
                                </td>
                                <td>    
                                    <?php  echo $gainprotein; ?>g
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Mỡ
                                </td>
                                <td>    
                                    <?php  echo $gainfat; ?>g
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Carb
                                </td>
                                <td>    
                                    <?php  echo $gaincarb; ?>g
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Facebookstuff -->
            <div class="fb-like" data-href="http://aneat.fit" data-width="" data-layout="standard" data-action="recommend" data-size="large" data-show-faces="true" data-share="true"></div>


            <div class="row" style="margin-top:20px;">
                <div class="col-md-9"> 
                    <p> Lập kế hoạch kiểm soát cân nặng lúc bạn bận rộn </p> 
                    
                </div>
                <div class="col-md-3"> 
                    
                    <a href="../" class="action-button yellow" role="button" style="background: #FFD700; color:black; font-size:12px;">LÊN THỰC ĐƠN!</a>
                </div>


            </div>


            </div>
        </div>







        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>