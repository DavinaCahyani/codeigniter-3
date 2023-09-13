<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

</head>
<body class="container py-5">
    <div class= "card justify-content-center mx-auto"style="width: 20rem;">
  <div class="card-body">
  <form action="connect_login.php" method="post"> 
    <h5 class="card-title text-center">Login Page</h5>
    <img src="https://binusasmg.sch.id/ppdb/logobinusa.png" class="img-thumbnail" alt="image">
    <p class="text-center">SMK Bina Nusantara</p>
    <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Email </label>
  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Email" name="email">
    <div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Password</label>
  <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Password" name="password">
</div>
<div class= "text-center">
<button type="submit" class="btn btn-primary">Login</button>
</div>
  </div>
  </form>
<br> 
          <p class="text-center">sudah punya akun? <a href="register.php">register akun</a></p>
  </div>
</div>

</body>
</html>