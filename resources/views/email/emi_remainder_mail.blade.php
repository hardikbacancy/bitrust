<!DOCTYPE html>
<html>
<head>
    <title>Welcome To Brahmani Investment Trust</title>
</head>

<body>
<?php $user=new \App\User();
   $penalty=$user->getPenalty();
?>
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
        <td>{{$penalty}}</td>
        <td>{{$userLoan->emi_amount+$penalty}}</td>
    </tr>
      @endforeach
    </tbody>
</table>


kindest,<br>
Brahmani Investement Trust!
</body>

</html>