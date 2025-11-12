const resultsData = [
  {
    question: "What is the capital of France?",
    options: ["Berlin", "Madrid", "Paris", "Rome"],
    correctIndex: 2,
    selectedIndex: 2,
  },
  {
    question: "Which planet is known as the Red Planet?",
    options: ["Earth", "Mars", "Venus", "Saturn"],
    correctIndex: 1,
    selectedIndex: 0,
  },
  {
    question: "What is 5 + 7?",
    options: ["10", "11", "12", "13"],
    correctIndex: 2,
    selectedIndex: 2,
  }
];

function renderResults() {
  let correct = 0;
  const container = document.getElementById("questions-container");

  resultsData.forEach((q, idx) => {
    const isCorrect = q.selectedIndex === q.correctIndex;
    if (isCorrect) correct++;

    const card = document.createElement("div");
    card.className = `relative w-full flex flex-col md:flex-row items-start gap-4 bg-white rounded-2xl shadow-md p-6 border ${isCorrect ? 'border-green-400' : 'border-red-400'} fade-in card-animate`;
    card.style.animationDelay = `${0.4 + idx * 0.15}s`;

    const left = document.createElement("div");
    left.className = "flex-1";

    const qTitle = document.createElement("h2");
    qTitle.className = "text-lg font-semibold text-orange-600 mb-2";
    qTitle.textContent = `Q${idx+1}: ${q.question}`;

    const optionsList = document.createElement("ul");
    optionsList.className = "space-y-2";

    q.options.forEach((opt, i) => {
      const li = document.createElement("li");
      li.className = "flex justify-between items-center px-4 py-2 rounded-lg transition relative";

      if (i === q.correctIndex) {
        li.classList.add("bg-green-50", "border", "border-green-400", "text-green-800", "font-medium");
        li.innerHTML = `<span>${String.fromCharCode(65 + i)}. ${opt}</span><span class="text-sm">✔️ Correct</span>`;
      } else if (i === q.selectedIndex && i !== q.correctIndex) {
        li.classList.add("bg-red-50", "border", "border-red-400", "text-red-700");
        li.innerHTML = `<span>${String.fromCharCode(65 + i)}. ${opt}</span><span class="text-sm">✖️ Your answer</span>`;
      } else {
        li.classList.add("bg-gray-50", "text-gray-700");
        li.innerHTML = `<span>${String.fromCharCode(65 + i)}. ${opt}</span>`;
      }

      optionsList.appendChild(li);
    });

    left.appendChild(qTitle);
    left.appendChild(optionsList);

    const right = document.createElement("div");
    right.className = "flex-none flex items-center justify-center";
    const badge = document.createElement("div");
    badge.className = "score-badge " + (isCorrect ? "bg-green-500 text-white" : "bg-red-500 text-white");
    badge.textContent = isCorrect ? "✔️" : "✖️";
    right.appendChild(badge);

    card.appendChild(left);
    card.appendChild(right);
    container.appendChild(card);
  });

  document.getElementById("total-questions").textContent = resultsData.length;
  document.getElementById("correct-answers").textContent = correct;
  document.getElementById("wrong-answers").textContent = resultsData.length - correct;
}

function setupEventListeners() {
  document.getElementById("sendMailBtn").addEventListener("click", () => {
    const btn = document.getElementById("sendMailBtn");
    btn.disabled = true;
    btn.innerText = "📨 Sending...";
    setTimeout(() => {
      btn.innerText = "✅ Sent!";
      btn.classList.remove("bg-orange-500");
      btn.classList.add("bg-green-500");
    }, 2000);
  });
}

// Initialize the page
document.addEventListener("DOMContentLoaded", () => {
  renderResults();
  setupEventListeners();
});