/* ---------- Ribbon Rain (top → bottom) ---------- */
(function ribbonRain(){
  const c=document.getElementById('rainCanvas');
  const ctx=c.getContext('2d');
  let W=c.width=innerWidth;
  let H=c.height=innerHeight;

  class Ribbon{
    constructor(){
      this.x=Math.random()*W;
      this.y=-50;
      this.w=Math.random()*6+2;
      this.h=Math.random()*30+60;
      this.speed=Math.random()*4+2;
      this.color=`hsl(${Math.random()*360},100%,60%)`;
    }
    draw(){
      ctx.save();
      ctx.translate(this.x,this.y);
      ctx.rotate(Math.random()*0.3-0.15);
      ctx.fillStyle=this.color;
      ctx.fillRect(-this.w/2,0,this.w,this.h);
      ctx.restore();
    }
    update(){
      this.y+=this.speed;
      if(this.y>H+100) Object.assign(this,new Ribbon());
    }
  }

  const ribbons=Array.from({length:60},()=>new Ribbon());
  function animate(){
    ctx.clearRect(0,0,W,H);
    ribbons.forEach(r=>{r.update();r.draw();});
    requestAnimationFrame(animate);
  }
  animate();
  window.addEventListener('resize',()=>{W=c.width=innerWidth;H=c.height=innerHeight;});
})();

/* ---------- Sparkle Confetti ---------- */
(function confetti(){
  const c=document.getElementById('particleCanvas');
  const ctx=c.getContext('2d');
  let W=c.width=innerWidth;
  let H=c.height=innerHeight;

  const particles=[];
  const colors=['#ffa502','#ff4757','#5f27cd','#00d2d3','#54a0ff'];

  class Sparkle{
    constructor(x,y){
      this.x=x;
      this.y=y;
      this.r=Math.random()*3+2;
      this.color=colors[Math.floor(Math.random()*colors.length)];
      this.vx=(Math.random()-0.5)*8;
      this.vy=Math.random()*-12-8;
      this.gravity=0.3;
    }
    draw(){
      ctx.beginPath();
      ctx.arc(this.x,this.y,this.r,0,Math.PI*2);
      ctx.fillStyle=this.color;
      ctx.fill();
    }
    update(){
      this.vy+=this.gravity;
      this.x+=this.vx;
      this.y+=this.vy;
      if(this.y>H) this.y=H;
      this.draw();
    }
  }

  function burst(x,y){
    for(let i=0;i<80;i++) particles.push(new Sparkle(x,y));
  }

  function animate(){
    ctx.clearRect(0,0,W,H);
    particles.forEach(p=>p.update());
    requestAnimationFrame(animate);
  }
  animate();

  /* timed bursts */
  setTimeout(()=>burst(W/2,H-100),300);
  setTimeout(()=>burst(W/2-150,H-50),700);
  setTimeout(()=>burst(W/2+150,H-80),1100);

  window.addEventListener('resize',()=>{W=c.width=innerWidth;H=c.height=innerHeight;});
})();