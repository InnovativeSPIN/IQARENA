<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dep-Board</title>
  <style>
    :root{
      --bg: #f36d14ff;
      --card: #ff7300ff;
      --path: #ffffffff;
      --path-strong: #ffffffff;
      --accent: #F97316; 
      --accent-2: #f59761ff; 
      --text: #e8ecff;
      --muted: #f87a04ff;
      --shadow: rgba(0,0,0,0.35);
    }
    *{box-sizing:border-box}
    html,body{height:100%; margin:0;}
    body{
      background: radial-gradient(1200px 800px at 70% -10%, #1b2246 0%, #0e1430 45%, #090d1f 100%);
      color:var(--text); font-family: Inter, Roboto, Segoe UI, sans-serif;
      display:flex; align-items:center; justify-content:center; padding:24px;
    }

    .app{width:min(980px, 96vw);}

    .header{display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:16px}
    .title{font-size:clamp(20px, 2.2vw, 28px); font-weight:800;}
    .controls{display:flex; gap:10px; align-items:center}
    .btn{
      appearance:none; border:none; padding:10px 14px; border-radius:12px; cursor:pointer; font-weight:700; 
      color:#0d0f1a; background:linear-gradient(180deg, #ffffff, #dfe8ff);
      box-shadow: 0 6px 16px var(--shadow), inset 0 0 0 1px #ffffffaa;
      transition: transform .12s ease;
    }
    .btn.secondary{ background:linear-gradient(180deg, #ffe7d4, #ffc9a0); color:#3b1b00 }
    .score{ font-weight:800; color:#fff; background: #18214a; padding:10px 14px; border-radius:12px; }

    .board{ position:relative; width:100%; height:620px; border-radius:24px; overflow:hidden; 
      background:linear-gradient(180deg, #f37a18ff 0%, #da580dff 100%);
    }

    svg.path{ position:absolute; inset:0; width:100%; height:100%; }
    .base-line{ stroke: var(--path); stroke-width: 10; fill: none; stroke-linecap: round; stroke-linejoin: round; }
    .progress-line{ stroke: var(--path-strong); stroke-width: 12; fill: none; stroke-linecap: round; stroke-linejoin: round; }

    #levels{ position:relative; width:100%; height:100%; }

    .level{
      position:absolute; width:90px; height:100px; border-radius:18px; border: 2px solid #ffffff1a; 
      background: linear-gradient(180deg, #f19346ff, #ee9520ff);
      display:flex; flex-direction:column; align-items:center; justify-content:center; gap:4px;
      color:var(--text); padding:6px;
      box-shadow: 0 10px 22px rgba(0,0,0,.35);
    }
    .level .num{ font-size:18px; font-weight:900; line-height:1; }
    .level .pts{ font-size:12px; font-weight:700; color:var(--muted); }
    .level .name{ font-size:13px; font-weight:600; text-align:center; line-height:1.2; }

    .level.current{ background: linear-gradient(180deg, #2c3d87, #1b2759); }
    .level.completed{ background: linear-gradient(180deg, #1f3d2a, #102616); }
    .level.locked{ filter: grayscale(.5) brightness(.8); opacity:.85 }
  </style>
</head>
<body>
  <div class="app">
    <div class="header">
      <div class="title">CSE - Department Leaderboard </div>
      <div class="controls">
        <div class="score">Score: <span id="score">0</span></div>
        <button id="nextBtn" class="btn">Next Level ▶</button>
        <button id="resetBtn" class="btn secondary">Reset ⟲</button>
      </div>
    </div>

    <div class="board" id="board">
      <svg class="path" viewBox="0 0 1000 620" preserveAspectRatio="none">
        <polyline id="baseLine" class="base-line" points="" />
        <polyline id="progressLine" class="progress-line" points="" />
      </svg>
      <div id="levels"></div>
    </div>
  </div>

  <script>
    const TOTAL_LEVELS = 10;
    const pointsFor = lvl => lvl * 10;

    // Example names (replace with your real team)
    const names = [
      "Alice", "Bob", "Charlie", "Diana", "Ethan",
      "Fiona", "George", "Hannah", "Ivan", "Julia"
    ];

    const pathPositionsPct = [
      { x: 8,  y: 86 },
      { x: 22, y: 74 },
      { x: 39, y: 62 },
      { x: 58, y: 68 },
      { x: 80, y: 56 },
      { x: 68, y: 40 },
      { x: 49, y: 33 },
      { x: 31, y: 40 },
      { x: 18, y: 28 },
      { x: 9,  y: 16 }
    ];

    let currentLevel = 1;
    let score = 0;

    const board = document.getElementById('board');
    const levelsWrap = document.getElementById('levels');
    const baseLine = document.getElementById('baseLine');
    const progressLine = document.getElementById('progressLine');
    const scoreEl = document.getElementById('score');
    const nextBtn = document.getElementById('nextBtn');
    const resetBtn = document.getElementById('resetBtn');

    const levelEls = [];
    for (let i = 1; i <= TOTAL_LEVELS; i++) {
      const btn = document.createElement('button');
      btn.className = 'level locked';
      btn.dataset.level = i;
      btn.innerHTML = `
        <div class="num">#${i}</div>
        <div class="name">${names[i-1]}</div>
        <div class="pts">+${pointsFor(i)}</div>
      `;
      btn.addEventListener('click', () => onChooseLevel(i));
      levelsWrap.appendChild(btn);
      levelEls.push(btn);
    }

    function onChooseLevel(i){
      if (i > currentLevel) return;
      currentLevel = i;
      updateUI();
    }

    function placeNodesAndPaths(){
      const rect = board.getBoundingClientRect();
      const toPx = (p) => ({ x: Math.round(p.x/100 * rect.width), y: Math.round(p.y/100 * rect.height) });
      const ptsPx = pathPositionsPct.map(toPx);

      ptsPx.forEach((pt, idx) => {
        const el = levelEls[idx];
        const size = 90;
        el.style.left = `${pt.x - size/2}px`;
        el.style.top  = `${pt.y - size/2}px`;
      });

      const toStr = (p) => `${p.x},${p.y}`;
      baseLine.setAttribute('points', ptsPx.map(toStr).join(' '));
      const upto = Math.max(1, currentLevel);
      const progPts = ptsPx.slice(0, upto).map(toStr).join(' ');
      progressLine.setAttribute('points', progPts);
    }

    function updateUI(){
      for (let i = 1; i <= TOTAL_LEVELS; i++){
        const el = levelEls[i-1];
        el.classList.remove('current','completed','locked');
        if (i < currentLevel){
          el.classList.add('completed');
        } else if (i === currentLevel){
          el.classList.add('current');
        } else {
          el.classList.add('locked');
        }
      }
      scoreEl.textContent = score;
      placeNodesAndPaths();
      nextBtn.disabled = currentLevel > TOTAL_LEVELS;
      nextBtn.textContent = currentLevel > TOTAL_LEVELS ? 'All Done ✔' : 'Next Level ▶';
    }

    function nextLevel(){
      if (currentLevel > TOTAL_LEVELS) return;
      score += pointsFor(currentLevel);
      currentLevel += 1;
      updateUI();
    }

    function reset(){
      currentLevel = 1;
      score = 0;
      updateUI();
    }

    nextBtn.addEventListener('click', nextLevel);
    resetBtn.addEventListener('click', reset);

    window.addEventListener('resize', placeNodesAndPaths);
    updateUI();
  </script>
</body>
</html>
