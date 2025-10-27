<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>YouTube LUX YT 1.5</title>
<style>
:root {
  --yt-dark: #0a0a0a;
  --yt-panel: #181818;
  --yt-red: #ff0000;
  --yt-text: #fff;
}
body {
  margin: 0;
  font-family: "Roboto","Segoe UI",sans-serif;
  background: radial-gradient(circle at top,#1a1a1a,#000);
  color: var(--yt-text);
  display: flex;
  flex-direction: column;
  align-items: center;
  min-height: 100vh;
  overflow-x: hidden;
}
header {
  position: fixed;
  top: 0; left: 0; right: 0;
  height: 58px;
  background: var(--yt-panel);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 18px;
  box-shadow: 0 2px 10px rgba(0,0,0,.6);
  z-index: 10;
}
.logo {display: flex; align-items: center; font-size:1.4em; font-weight:700;}
.logo span {color: var(--yt-red); margin-right:8px;}
#fpsCounter {background: rgba(255,255,255,.05); border-radius:8px; padding:4px 10px; font-size:.85em; color:#0f0; backdrop-filter: blur(4px);}
main {text-align:center; margin-top:120px; padding:20px;}
h1 {font-size:2.3em; margin-bottom:8px; color:#fff;}
p {color:#bbb; font-size:1.1em; margin-bottom:35px;}
.btn {border:none; border-radius:30px; color:#fff; font-weight:600; font-size:1.1em; padding:14px 36px; cursor:pointer; box-shadow:0 4px 15px rgba(255,0,0,.4); background:var(--yt-red); transition: all .25s ease; margin:8px;}
.btn:hover {box-shadow:0 6px 25px rgba(255,0,0,.6); transform:translateY(-2px);}
.btn:active {transform:scale(.96);}
.subscribe-btn {margin-top:30px; background: var(--yt-red); box-shadow:0 4px 15px rgba(255,0,0,.4);}
.subscribe-btn:hover {background:#ff2a2a; box-shadow:0 6px 25px rgba(255,0,0,.6);}

/* Модальное окно имени */
.name-modal, .admin-modal {
  position: fixed; inset:0; background:rgba(0,0,0,.8); display:flex; align-items:center; justify-content:center;
  z-index:9999; backdrop-filter: blur(6px);
}
.name-box, .admin-box {background:var(--yt-panel); padding:30px; border-radius:20px; box-shadow:0 0 25px rgba(255,0,0,.3); text-align:center; width:90%; max-width:360px; animation:fadeIn .4s ease;}
.name-box h2, .admin-box h3 {margin-bottom:20px;}
.name-box input, .admin-box input {width:100%; padding:12px; border:none; border-radius:10px; margin-bottom:20px; font-size:1em; outline:none;}
.user {background:#222; border-radius:10px; margin:10px auto; padding:10px; width:250px; font-size:.95em; box-shadow:0 0 10px rgba(255,0,0,0.2);}
@keyframes fadeIn {from{opacity:0; transform:scale(.8);} to{opacity:1; transform:scale(1);}}
footer {margin-top:60px; color:#888; font-size:.9em;}
footer a {color:#ff4444; text-decoration:none; margin:0 10px;}
footer a:hover {color:#fff;}
@media(max-width:700px){h1{font-size:1.8em;} p{font-size:1em;} .btn{font-size:1em;padding:12px 26px;} header{height:54px;padding:0 10px;}}
</style>
</head>
<body>

<header>
  <div class="logo"><span>▶</span>YouTube</div>
  <div id="fpsCounter">FPS: 0</div>
</header>

<main>
  <h1 id="welcomeTitle">🔥 YouTube LUX YT</h1>
  <p id="welcomeText">Простой и красивый интерфейс YouTube — плавные кнопки и быстрый дизайн 🚀</p>

  <button class="btn" id="buyPremium">💎 Купить Premium</button>
  <button class="btn" id="adminBtn">⚙️ Админ-панель</button>
  <button class="btn subscribe-btn" id="subscribeBtn">❤️ Подписаться</button>

  <footer>
    <a href="https://www.youtube.com/" target="_blank">YouTube</a> | 
    <a href="https://github.com/" target="_blank">GitHub</a> | 
    <a href="https://instagram.com/" target="_blank">Instagram</a>
  </footer>
</main>

<!-- Модальное окно имени -->
<div class="name-modal" id="nameModal">
  <div class="name-box">
    <h2>👋 Введите ваше имя</h2>
    <input type="text" id="userNameInput" placeholder="Ваше имя...">
    <button class="btn" id="saveNameBtn">Продолжить</button>
  </div>
</div>

<!-- Модальное окно админа -->
<div class="admin-modal" id="adminModal" style="display:none;">
  <div class="admin-box" id="adminLogin">
    <h3>Вход в админ-панель</h3>
    <input type="password" id="adminPass" placeholder="Введите пароль">
    <button class="btn" id="loginAdmin">Войти</button>
    <button class="btn" id="closeAdminModal">Закрыть</button>
  </div>
  <div class="admin-box" id="adminPanel" style="display:none;">
    <h3>👑 Админ-панель</h3>
    <input type="text" id="userNameAdmin" placeholder="Имя пользователя">
    <button class="btn" id="addUser">Создать</button>
    <div id="usersList"></div>
    <button class="btn" id="exitAdmin">Выйти</button>
  </div>
</div>

<script>
const fpsDisplay=document.getElementById('fpsCounter');
const subscribeBtn=document.getElementById('subscribeBtn');
const nameModal=document.getElementById('nameModal');
const userNameInput=document.getElementById('userNameInput');
const saveNameBtn=document.getElementById('saveNameBtn');
const welcomeTitle=document.getElementById('welcomeTitle');

// FPS
let lastTime=performance.now(),frames=0,fps=0;
function measureFPS(now){
  frames++;
  const delta=now-lastTime;
  if(delta>=1000){fps=frames; fpsDisplay.textContent="FPS: "+fps; frames=0; lastTime=now;}
  requestAnimationFrame(measureFPS);
}
requestAnimationFrame(measureFPS);

// Пользователь
let storedName=localStorage.getItem('yt_user_name');
let isPremium=localStorage.getItem('yt_user_premium')==='true';
if(!storedName){nameModal.style.display='flex';} 
else {welcomeTitle.textContent=`👋 Добро пожаловать, ${storedName}!`;
      if(isPremium) window.location.href='premium.html';}

// Сохранение имени
saveNameBtn.addEventListener('click',()=>{
  const name=userNameInput.value.trim();
  if(name!==""){
    localStorage.setItem('yt_user_name',name);
    nameModal.style.display='none';
    welcomeTitle.textContent=`👋 Добро пожаловать, ${name}!`;
    if(localStorage.getItem('yt_user_premium')==='true'){
      window.location.href='premium.html';
    }
  }
});

// Подписка
subscribeBtn.addEventListener('click',()=>{window.location.href='https://www.youtube.com/@YouTube';});

// Купить премиум
document.getElementById('buyPremium').addEventListener('click',()=>{window.location.href='premium.html';});

// Админ-панель
const adminBtn=document.getElementById('adminBtn');
const adminModal=document.getElementById('adminModal');
const loginAdmin=document.getElementById('loginAdmin');
const adminPanel=document.getElementById('adminPanel');
const closeAdminModal=document.getElementById('closeAdminModal');
const exitAdmin=document.getElementById('exitAdmin');
const addUser=document.getElementById('addUser');
const userNameAdmin=document.getElementById('userNameAdmin');
const usersList=document.getElementById('usersList');

let users=JSON.parse(localStorage.getItem('yt_users') || '[]');
function save(){localStorage.setItem('yt_users',JSON.stringify(users));}
function render(){
  usersList.innerHTML='';
  users.forEach((u,i)=>{
    const div=document.createElement('div');
    div.className='user';
    div.innerHTML=`<b>${u.name}</b> ${u.premium?'💎':''}<br>
    <button class="btn" onclick="give(${i})">Выдать Premium</button>
    <button class="btn" onclick="del(${i})">Удалить</button>`;
    usersList.appendChild(div);
  });
}
function give(i){users[i].premium=true; save(); localStorage.setItem('yt_user_premium','true'); render();}
function del(i){users.splice(i,1); save(); render();}

adminBtn.onclick=()=>{adminModal.style.display='flex';};
closeAdminModal.onclick=()=>{adminModal.style.display='none';};
loginAdmin.onclick=()=>{
  const pass=document.getElementById('adminPass').value;
  if(pass==='admin123'){loginAdmin.style.display='none'; adminPanel.style.display='block'; render();}
  else alert('Неверный пароль!');
};
exitAdmin.onclick=()=>{adminPanel.style.display='none'; loginAdmin.style.display='block'; adminModal.style.display='none';};

// Добавить пользователя
addUser.onclick=()=>{
  const name=userNameAdmin.value.trim();
  if(!name) return alert('Введите имя');
  users.push({name,premium:false});
  save(); render();
};
</script>
</body>
</html>