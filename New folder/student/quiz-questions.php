<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Simple Quiz</title>
</head>
<body>

  <h2>Quiz</h2>
  <div id="quiz-container">
    <p id="question">Loading question...</p>
    <form id="quiz-form">
      <div>
        <input type="radio" name="option" value="a" id="opt-a">
        <label for="opt-a" id="label-a">Option A</label>
      </div>
      <div>
        <input type="radio" name="option" value="b" id="opt-b">
        <label for="opt-b" id="label-b">Option B</label>
      </div>
      <div>
        <input type="radio" name="option" value="c" id="opt-c">
        <label for="opt-c" id="label-c">Option C</label>
      </div>
      <div>
        <input type="radio" name="option" value="d" id="opt-d">
        <label for="opt-d" id="label-d">Option D</label>
      </div>
      <br>
      <button type="submit">Submit</button>
    </form>

    <p id="result"></p>
  </div>

  <script>
    // Sample question data (you can replace with API call)
    const question = {
      text: "What is the capital of India?",
      options: {
        a: "Mumbai",
        b: "Kolkata",
        c: "New Delhi",
        d: "Chennai"
      },
      correct: "c"
    };

    // Load question
    document.getElementById('question').textContent = question.text;
    document.getElementById('label-a').textContent = question.options.a;
    document.getElementById('label-b').textContent = question.options.b;
    document.getElementById('label-c').textContent = question.options.c;
    document.getElementById('label-d').textContent = question.options.d;

    // Form submit
    document.getElementById('quiz-form').addEventListener('submit', function(e) {
      e.preventDefault();
      const selected = document.querySelector('input[name="option"]:checked');

      if (!selected) {
        alert('Please select an option');
        return;
      }

      const result = document.getElementById('result');
      if (selected.value === question.correct) {
        result.textContent = "Correct!";
      } else {
        result.textContent = "Wrong answer.";
      }
    });
  </script>
</body>
</html>
