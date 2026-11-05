<style>
    body {
  font-family: sans-serif;
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background-color: #f0f0f0;
}

.container {
  background-color: #fff;
  padding: 30px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 400px;
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input,
textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 3px;
  margin-bottom: 15px;
  box-sizing: border-box;
}

textarea {
  resize: vertical;
}

button {
  background-color: #3498db;
  color: #fff;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 3px;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
}

button:hover {
  background-color: #2980b9;
}

@media (max-width: 768px) {
  .container {
    padding: 20px;
  }
}

</style>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Book Appointment</title>
</head>
<body>
  <div class="container">
    <h1>Book Your Appointment</h1>
    <form action="{{route('booking.store')}}" method="POST">
        @csrf
        @method('POST')
        @if ($errors->any())
          <div style="background:#fdecea;color:#b71c1c;padding:10px 14px;border-radius:6px;margin-bottom:12px;">
            @foreach ($errors->all() as $error)<div>{{ $error }}</div>@endforeach
          </div>
        @endif
      <label for="name">Name:</label>
      <input type="text" id="name" name="name" required>
      <label for="date">Date:</label>
      <input type="date" id="date" name="date" required>
      <label for="time">Time:</label>
      <input type="time" id="time" name="time" required>
      <label for="complaints">Complaints:</label>
      <textarea id="complaints" name="complaints" rows="4" required></textarea>
      <label for="phone">Phone Number:</label>
      <input type="tel" id="phone" name="phone" placeholder="070100100100" required >
      <button type="submit">Book Now</button>
    </form>
  </div>
</body>
</html>
