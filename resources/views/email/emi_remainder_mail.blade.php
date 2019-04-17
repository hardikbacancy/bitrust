<!doctype html>
<html>
<head><meta charset="utf-8">
    <title>Welcome To Shree Brahmani Investor INC</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" />
    <style type="text/css">* { padding:0; margin:0; box-sizing: border-box;}
        table { border:0 none; border-spacing:0; width:100%}
        th, td{ text-align:center; font-weight:normal; vertical-align:top;}
        tr,th{  border-bottom: 1px solid #ddd;  margin: 10px;   padding: 10px;}
        body{ font-family: 'Poppins', sans-serif; font-size:18px; color:#2b2b2b; font-weight:normal; margin:0; padding:0;}
        table.wrapper{ width:720px; margin:20px auto; background:#eaeff2; padding:30px;}
        table.wrapper tr td.first-part img{ margin:10px 0 18px 0;}
        table.wrapper tr td.first-part h3{ font-size:18px; font-weight:600; margin-bottom:3px;}
        table.wrapper tr td.first-part h3 span{ font-weight:400;}
        table.wrapper tr td.first-part p{ font-size:20px; font-weight:300; line-height:24px; margin-bottom:20px;}
        table.wrapper tr td.second-part{ background:#FFF; padding:40px 20px; border-radius:5px; margin-bottom:30px;display:block;}
        table.wrapper tr td.second-part img{ margin:0 0 10px 0; width:65px;}
        table.wrapper tr td.second-part p{ font-size:18px; font-weight:400; line-height:28px; }
        table.wrapper tr td.second-part hr{ width:420px; margin:0 auto;}
        table.wrapper tr td.second-part .detailbox{margin: 30px auto;}
        table.wrapper tr td.second-part p.small-text{ font-size:16px; color:#8d6e77; font-weight:400; margin:31px 0 14px 0;}
        /*table.wrapper tr td.second-part a{ background:#f1911f; font-size:16px; color:#FFF; font-weight:500; width:150px; padding:8px 10px; border-radius:5px; text-decoration:none; display:inline-block;}*/

        table.wrapper tr td.third-part{ background:#FFF; padding:40px 10px; border-radius:5px;}
        table.wrapper tr td.third-part p{ font-size:14px; color:#505050; font-weight:400; margin-bottom:4px;}
        table.wrapper tr td.third-part p.font-small{ font-size:16px; color:#2b2b2b; margin-bottom:0;}
        /*.button_style{ background: #f6911f; font-size: 16px;color: #FFF; font-weight: 500; padding: 5px 20px; border-radius: 5px; text-decoration: none; display: inline-block; cursor:pointer;}*/
        table.wrapper tr td.second-part h3 span{ font-weight:400;}
        /*table.wrapper tr td.second-part a:hover { text-decoration: none; background: #ce7712;}*/
        /*--------------media query css start------------------*/
        @media (max-width:767px) {
            table.wrapper{ width:100%; padding:20px;}

        }

        @media (max-width:640px) {
            table.wrapper tr td.second-part hr{ width:80%;}

        }

        @media (max-width:480px) {
            table.wrapper tr td.first-part p br{ display:none;}

        }
    </style>
</head>
<body>
<table class="wrapper">
    <tbody>
    <tr>
        <td class="first-part"><img alt="" src="https://bitrust.ca/home/images/logo.png" style="width: 126px; height: 33px;" /></td>
    </tr>
    <tr>
        <td class="second-part">
            <?php $user=new \App\User();
            $penalty=$user->getPenalty();
            $count=0;
            ?>
            <p>Hello,  @foreach($userLoanMgmt as $key=>$userLoan) @if($key==0) {{$userLoan->name}} @endif @endforeach</p>
            <p>This is reminder for your EMI which is pending.</p>
            <table class="table">
                <thead>
                <tr>
                    <th>EMI Amount</th>
                    <th>EMI Date</th>
                    <th>Penalty</th>
                    <th>Total EMI Amount</th>
                </tr>
                </thead>
                <tbody>
                @foreach($userLoanMgmt as $userLoan)
                    <tr>
                        <td>{{$userLoan->emi_amount}}</td>
                        <td>{{$userLoan->tenuar_date}}</td>
                        <td>
                            @if(isset($userLoan->penalty))
                                {{$userLoan->penalty}}
                            @else
                                {{$penalty}}
                            @endif
                        </td>
                    <!--  <td>{{$penalty}}</td> -->
                        <td>@if(isset($userLoan->penalty)) {{$userLoan->emi_amount+$userLoan->penalty}} @else {{$userLoan->emi_amount+$penalty}} @endif </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </td>
    </tr>
    <tr>
        <td class="third-part">
            <p>Copyright &copy; 2019</p>
            <p class="font-small">Shree Brahmani Investor INC!</p>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>







