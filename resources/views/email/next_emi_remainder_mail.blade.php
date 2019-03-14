<!DOCTYPE html>
<html>
<head>
    <title>Welcome To Brahmani Investment Trust</title>
</head>

<body>

<table class="table">
    <thead>
    <tr>
        <th>EMI Amount</th>
        <th>EMI Due Date</th>
    </tr>
    </thead>
    <tbody>
     @foreach($userLoanMgmt as $userLoan)
    <tr>
        <td>{{$userLoan->emi_amount}}</td>
        <td>{{$userLoan->tenuar_date}}</td>
    </tr>
      @endforeach
    </tbody>
</table>


kindest,<br>
Brahmani Investement Trust!
</body>

</html>