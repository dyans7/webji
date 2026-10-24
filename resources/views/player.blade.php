<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webji Hi-Fi Music Player</title>
    <meta name="description" content="Webji Audio Pro — Equalizer 10-band dan playlist editor premium.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--primary:#6366f1;--primary-light:#818cf8;--accent:#ec4899;--accent-glow:rgba(236,72,153,.35);--bg-main:#07090e;--panel-bg:rgba(18,24,38,.7);--card-border:rgba(255,255,255,.08);--text-main:#f8fafc;--text-muted:#94a3b8;--progress:linear-gradient(90deg,#6366f1,#ec4899);}
        *{box-sizing:border-box;margin:0;padding:0;font-family:'Plus Jakarta Sans',-apple-system,BlinkMacSystemFont,sans-serif;-webkit-font-smoothing:antialiased;}
        body{background:var(--bg-main);color:var(--text-main);min-height:100vh;display:flex;flex-direction:column;overflow-x:hidden;}
        .ambient-glow{position:fixed;top:0;left:0;width:100vw;height:100vh;pointer-events:none;z-index:0;overflow:hidden;}
        .glow-1{position:absolute;width:600px;height:600px;background:radial-gradient(circle,rgba(99,102,241,.25) 0%,transparent 70%);top:-150px;left:-100px;filter:blur(80px);animation:pg 10s infinite alternate ease-in-out;}
        .glow-2{position:absolute;width:550px;height:550px;background:radial-gradient(circle,rgba(236,72,153,.22) 0%,transparent 70%);bottom:-100px;right:-100px;filter:blur(80px);animation:pg 14s infinite alternate-reverse ease-in-out;}
        @keyframes pg{0%{transform:scale(1) translate(0,0)}50%{transform:scale(1.15) translate(30px,20px)}100%{transform:scale(.95) translate(-20px,-10px)}}
        header{position:relative;z-index:20;display:flex;align-items:center;justify-content:space-between;padding:18px 36px;background:rgba(11,15,25,.75);backdrop-filter:blur(20px);border-bottom:1px solid var(--card-border);}
        .hbrand{display:flex;align-items:center;gap:12px;}
        .hicon{width:42px;height:42px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#ec4899);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 15px rgba(99,102,241,.4);}
        .htext h1{font-size:18px;font-weight:800;letter-spacing:-.3px;}
        .htext span{font-size:11px;color:#818cf8;font-weight:600;letter-spacing:1px;text-transform:uppercase;}
        .upanel{display:flex;align-items:center;gap:16px;}
        .uinfo{display:flex;align-items:center;gap:10px;background:rgba(255,255,255,.05);padding:6px 14px 6px 8px;border-radius:100px;border:1px solid var(--card-border);}
        .uavatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#ec4899,#f59e0b);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:700;}
        .uname{font-size:13px;font-weight:600;}
        .logout-btn{background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.3);color:#fca5a5;padding:8px 16px;border-radius:10px;font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;display:flex;align-items:center;gap:6px;}
        .logout-btn:hover{background:#ef4444;color:#fff;transform:translateY(-1px);}
        main{position:relative;z-index:10;flex:1;display:grid;grid-template-columns:1fr 400px;gap:28px;max-width:1440px;width:100%;margin:0 auto;padding:28px 36px;}
        @media(max-width:1100px){main{grid-template-columns:1fr;}}
        .left-col{display:flex;flex-direction:column;gap:20px;}
        /* Player */
        .player-stage{background:var(--panel-bg);backdrop-filter:blur(28px);border:1px solid var(--card-border);border-radius:28px;padding:32px 36px;display:flex;flex-direction:column;justify-content:space-between;box-shadow:0 25px 50px -12px rgba(0,0,0,.6);position:relative;overflow:hidden;}
        .badge{position:absolute;top:22px;right:26px;display:inline-flex;align-items:center;gap:8px;background:rgba(99,102,241,.18);border:1px solid rgba(99,102,241,.4);padding:6px 14px;border-radius:100px;font-size:11px;font-weight:700;color:#a5b4fc;letter-spacing:.5px;text-transform:uppercase;}
        .pdot{width:7px;height:7px;border-radius:50%;background:#22c55e;box-shadow:0 0 10px #22c55e;animation:blink 1.5s infinite ease-in-out;}
        @keyframes blink{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.4;transform:scale(.85)}}
        .vis-wrap{display:flex;flex-direction:column;align-items:center;padding:16px 0 20px;}
        .vinyl-wrap{position:relative;width:220px;height:220px;margin-bottom:18px;}
        .vinyl{position:absolute;top:0;left:0;width:100%;height:100%;border-radius:50%;background:radial-gradient(circle,#1e293b 0%,#0f172a 40%,#020617 100%);box-shadow:0 15px 35px rgba(0,0,0,.7),0 0 0 8px rgba(255,255,255,.04);display:flex;align-items:center;justify-content:center;border:2px solid rgba(255,255,255,.1);}
        .vinyl.playing{animation:spin 16s linear infinite;}
        @keyframes spin{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
        .vinyl-inner{width:100px;height:100px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#ec4899);box-shadow:0 0 25px rgba(236,72,153,.5);display:flex;align-items:center;justify-content:center;}
        .vinyl-inner::after{content:'';width:22px;height:22px;background:#07090e;border-radius:50%;border:3px solid rgba(255,255,255,.25);display:block;}
        .vizcanvas{width:100%;height:68px;margin-bottom:10px;border-radius:12px;}
        .tdetails{text-align:center;margin-bottom:18px;}
        .ttitle{font-size:22px;font-weight:800;letter-spacing:-.5px;margin-bottom:5px;}
        .tartist{font-size:14px;color:var(--text-muted);font-weight:500;}
        .timeline{margin-bottom:22px;}
        .tlabels{display:flex;justify-content:space-between;font-size:12px;color:var(--text-muted);font-weight:600;margin-top:7px;}
        .pbar-wrap{width:100%;height:8px;background:rgba(255,255,255,.1);border-radius:100px;cursor:pointer;overflow:hidden;transition:height .2s;}
        .pbar-wrap:hover{height:10px;}
        .pbar-fill{height:100%;width:0%;background:var(--progress);border-radius:100px;transition:width .1s linear;}
        .ctrls{display:flex;align-items:center;justify-content:center;gap:16px;}
        .cbtn{background:rgba(255,255,255,.06);border:1px solid var(--card-border);color:#fff;width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .25s cubic-bezier(.4,0,.2,1);}
        .cbtn:hover{background:rgba(255,255,255,.15);transform:scale(1.08);}
        .cbtn.active{color:var(--accent);border-color:var(--accent);background:rgba(236,72,153,.15);}
        .cbtn-play{width:64px;height:64px;background:linear-gradient(135deg,#6366f1,#ec4899);box-shadow:0 10px 25px rgba(99,102,241,.45);border:none;}
        .cbtn-play:hover{transform:scale(1.1);box-shadow:0 15px 35px rgba(236,72,153,.55);}
        .bbar{display:flex;align-items:center;justify-content:space-between;margin-top:22px;padding-top:18px;border-top:1px solid rgba(255,255,255,.06);}
        .vol-ctrl{display:flex;align-items:center;gap:10px;width:160px;}
        .vol-slider{-webkit-appearance:none;width:100%;height:5px;background:rgba(255,255,255,.15);border-radius:5px;outline:none;cursor:pointer;}
        .vol-slider::-webkit-slider-thumb{-webkit-appearance:none;width:14px;height:14px;border-radius:50%;background:#fff;cursor:pointer;box-shadow:0 0 10px rgba(0,0,0,.5);}
        .eq-btn{display:flex;align-items:center;gap:8px;background:rgba(99,102,241,.15);border:1px solid rgba(99,102,241,.35);color:var(--primary-light);padding:8px 16px;border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;transition:all .2s;}
        .eq-btn:hover,.eq-btn.active{background:var(--primary);border-color:var(--primary);color:#fff;box-shadow:0 0 20px rgba(99,102,241,.4);}
        /* EQ Panel */
        .eq-panel{background:rgba(10,14,28,.88);backdrop-filter:blur(24px);border:1px solid rgba(99,102,241,.28);border-radius:22px;padding:24px 28px;display:none;animation:slideDown .3s ease;}
        .eq-panel.open{display:block;}
        @keyframes slideDown{from{opacity:0;transform:translateY(-12px)}to{opacity:1;transform:translateY(0)}}
        .eq-hdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;}
        .eq-hdr-l{display:flex;align-items:center;gap:14px;}
        .eq-title{font-size:15px;font-weight:700;}
        .eq-en-wrap{display:flex;align-items:center;gap:8px;font-size:12px;color:var(--text-muted);font-weight:600;}
        .tswitch{position:relative;width:36px;height:20px;flex-shrink:0;}
        .tswitch input{opacity:0;width:0;height:0;}
        .tslider{position:absolute;cursor:pointer;inset:0;background:rgba(255,255,255,.15);border-radius:20px;transition:.3s;}
        .tslider::before{content:'';position:absolute;height:14px;width:14px;left:3px;bottom:3px;background:white;border-radius:50%;transition:.3s;}
        input:checked+.tslider{background:var(--primary);}
        input:checked+.tslider::before{transform:translateX(16px);}
        .eq-presets{display:flex;gap:7px;flex-wrap:wrap;margin-bottom:22px;}
        .eq-pb{background:rgba(255,255,255,.06);border:1px solid var(--card-border);color:var(--text-muted);padding:6px 13px;border-radius:100px;font-size:12px;font-weight:600;cursor:pointer;transition:all .2s;}
        .eq-pb:hover{background:rgba(99,102,241,.2);border-color:rgba(99,102,241,.4);color:var(--primary-light);}
        .eq-pb.active{background:rgba(99,102,241,.25);border-color:var(--primary);color:var(--primary-light);box-shadow:0 0 12px rgba(99,102,241,.25);}
        .eq-bands{display:flex;align-items:flex-start;justify-content:space-between;height:190px;padding:0 4px;gap:4px;}
        .eq-band{display:flex;flex-direction:column;align-items:center;gap:6px;flex:1;}
        .eq-bval{font-size:10px;font-weight:700;color:var(--primary-light);text-align:center;min-width:32px;}
        .eq-bwrap{flex:1;display:flex;align-items:center;justify-content:center;height:130px;position:relative;width:100%;}
        .eq-zline{position:absolute;left:50%;transform:translateX(-50%);width:100%;height:1px;background:rgba(255,255,255,.12);top:50%;pointer-events:none;}
        .eq-bs{-webkit-appearance:none;writing-mode:vertical-lr;direction:rtl;width:5px;height:120px;background:rgba(255,255,255,.1);border-radius:6px;outline:none;cursor:pointer;}
        .eq-bs::-webkit-slider-thumb{-webkit-appearance:none;width:17px;height:17px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#ec4899);cursor:pointer;box-shadow:0 0 10px rgba(99,102,241,.6);border:2px solid rgba(255,255,255,.3);transition:transform .15s;}
        .eq-bs::-webkit-slider-thumb:hover{transform:scale(1.2);}
        .eq-bfreq{font-size:9px;color:var(--text-muted);font-weight:600;text-align:center;white-space:nowrap;}
        .eq-extra{display:flex;gap:14px;margin-top:18px;padding-top:15px;border-top:1px solid rgba(255,255,255,.06);flex-wrap:wrap;}
        .eq-eg{display:flex;flex-direction:column;gap:8px;flex:1;min-width:140px;}
        .eq-el{font-size:11px;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:.6px;display:flex;justify-content:space-between;}
        .eq-es{-webkit-appearance:none;width:100%;height:5px;background:rgba(255,255,255,.1);border-radius:5px;outline:none;cursor:pointer;}
        .eq-es::-webkit-slider-thumb{-webkit-appearance:none;width:14px;height:14px;border-radius:50%;background:var(--accent);cursor:pointer;box-shadow:0 0 8px var(--accent-glow);}
        .eq-reset{background:rgba(239,68,68,.12);border:1px solid rgba(239,68,68,.28);color:#fca5a5;padding:8px 18px;border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;transition:all .2s;align-self:center;}
        .eq-reset:hover{background:#ef4444;color:#fff;}
        /* Sidebar */
        .playlist-panel{background:var(--panel-bg);backdrop-filter:blur(28px);border:1px solid var(--card-border);border-radius:28px;padding:24px;display:flex;flex-direction:column;box-shadow:0 25px 50px -12px rgba(0,0,0,.6);}
        .ptabs{display:flex;gap:4px;background:rgba(255,255,255,.04);padding:4px;border-radius:14px;margin-bottom:18px;}
        .ptab{flex:1;padding:9px 0;border-radius:10px;border:none;background:transparent;color:var(--text-muted);font-size:13px;font-weight:600;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:6px;}
        .ptab.active{background:rgba(99,102,241,.25);color:var(--primary-light);}
        .ptab:hover:not(.active){background:rgba(255,255,255,.06);color:var(--text-main);}
        .tabcon{display:none;flex-direction:column;flex:1;}
        .tabcon.active{display:flex;}
        .plhdr{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;}
        .plhdr-l{display:flex;align-items:center;gap:10px;}
        .plhdr-title{font-size:15px;font-weight:700;}
        .plcount{font-size:12px;background:rgba(255,255,255,.08);padding:4px 10px;border-radius:100px;color:var(--text-muted);}
        .pladd-btn{display:flex;align-items:center;gap:6px;background:rgba(99,102,241,.15);border:1px solid rgba(99,102,241,.3);color:var(--primary-light);padding:7px 13px;border-radius:10px;font-size:12px;font-weight:700;cursor:pointer;transition:all .2s;}
        .pladd-btn:hover{background:var(--primary);color:#fff;border-color:var(--primary);}
        .tlist{list-style:none;overflow-y:auto;max-height:430px;padding-right:4px;display:flex;flex-direction:column;gap:6px;}
        .tlist::-webkit-scrollbar{width:4px;}
        .tlist::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:10px;}
        .titem{display:flex;align-items:center;gap:10px;padding:10px 11px;border-radius:13px;transition:all .2s;background:rgba(255,255,255,.02);border:1px solid transparent;}
        .titem:hover{background:rgba(255,255,255,.06);border-color:rgba(255,255,255,.08);}
        .titem.active{background:rgba(99,102,241,.16);border-color:rgba(99,102,241,.35);}
        .titem.drag-over{border-color:var(--accent);background:rgba(236,72,153,.1);}
        .titem.dragging{opacity:.35;}
        .dhandle{cursor:grab;color:var(--text-muted);opacity:.35;flex-shrink:0;transition:opacity .2s;line-height:0;}
        .titem:hover .dhandle{opacity:.7;}
        .dhandle:active{cursor:grabbing;}
        .tnum{font-size:12px;font-weight:700;color:var(--text-muted);width:18px;text-align:center;flex-shrink:0;}
        .titem.active .tnum{color:#818cf8;}
        .tinfo{flex:1;min-width:0;cursor:pointer;}
        .tname{font-size:13px;font-weight:600;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;}
        .tartist2{font-size:11px;color:var(--text-muted);margin-top:2px;}
        .tdur{font-size:11px;color:var(--text-muted);font-weight:500;flex-shrink:0;}
        .tactions{display:flex;gap:4px;opacity:0;transition:opacity .2s;flex-shrink:0;}
        .titem:hover .tactions{opacity:1;}
        .tact-btn{background:rgba(255,255,255,.07);border:none;color:var(--text-muted);width:26px;height:26px;border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;transition:all .15s;}
        .tact-btn:hover{background:rgba(239,68,68,.3);color:#fca5a5;}
        .tact-btn.edit:hover{background:rgba(99,102,241,.3);color:var(--primary-light);}
        .eqbars{display:inline-flex;align-items:flex-end;gap:2px;height:14px;}
        .eqbar{width:3px;background:var(--accent);border-radius:2px;animation:bnc .8s infinite ease-in-out alternate;}
        .eqbar:nth-child(1){height:7px}.eqbar:nth-child(2){animation-delay:.2s;height:10px}.eqbar:nth-child(3){animation-delay:.4s;height:14px}
        @keyframes bnc{0%{height:3px}100%{height:14px}}
        .upbox{margin-top:12px;padding:13px;border:1px dashed rgba(255,255,255,.15);border-radius:13px;text-align:center;background:rgba(255,255,255,.02);transition:all .2s;cursor:pointer;}
        .upbox:hover{border-color:var(--primary-light);background:rgba(99,102,241,.06);}
        .uplabel{font-size:12px;color:#cbd5e1;display:flex;align-items:center;justify-content:center;gap:8px;font-weight:600;cursor:pointer;}
        .upinput{display:none;}
        .addform{display:flex;flex-direction:column;gap:14px;}
        .addform-title{font-size:14px;font-weight:700;}
        .ffield{display:flex;flex-direction:column;gap:7px;}
        .flabel{font-size:11px;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:.6px;}
        .finput{background:rgba(255,255,255,.06);border:1px solid var(--card-border);color:var(--text-main);padding:11px 14px;border-radius:12px;font-size:13px;font-family:inherit;outline:none;transition:border-color .2s;width:100%;}
        .finput:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.15);}
        .fsubmit{background:linear-gradient(135deg,#6366f1,#ec4899);color:#fff;border:none;padding:13px;border-radius:13px;font-size:14px;font-weight:700;cursor:pointer;transition:all .2s;box-shadow:0 8px 20px rgba(99,102,241,.35);}
        .fsubmit:hover{box-shadow:0 12px 28px rgba(99,102,241,.5);transform:translateY(-1px);}
        .divdr{display:flex;align-items:center;gap:12px;}
        .divdr-line{flex:1;height:1px;background:rgba(255,255,255,.08);}
        .divdr-txt{font-size:12px;color:var(--text-muted);font-weight:600;}
        /* Modal */
        .moverlay{position:fixed;inset:0;background:rgba(0,0,0,.72);backdrop-filter:blur(8px);z-index:1000;display:flex;align-items:center;justify-content:center;opacity:0;pointer-events:none;transition:opacity .25s;}
        .moverlay.open{opacity:1;pointer-events:all;}
        .mcard{background:#0d1120;border:1px solid rgba(99,102,241,.3);border-radius:22px;padding:32px;width:100%;max-width:480px;box-shadow:0 40px 80px rgba(0,0,0,.7);transform:scale(.95) translateY(12px);transition:all .25s;}
        .moverlay.open .mcard{transform:scale(1) translateY(0);}
        .mtitle{font-size:18px;font-weight:800;margin-bottom:22px;display:flex;align-items:center;gap:10px;}
        .mfield{margin-bottom:15px;}
        .mfield label{display:block;font-size:11px;color:var(--text-muted);font-weight:700;text-transform:uppercase;letter-spacing:.6px;margin-bottom:7px;}
        .minput{width:100%;background:rgba(255,255,255,.06);border:1px solid var(--card-border);color:var(--text-main);padding:12px 15px;border-radius:12px;font-size:14px;font-family:inherit;outline:none;transition:border-color .2s;}
        .minput:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.15);}
        .mfooter{display:flex;gap:10px;margin-top:24px;}
        .mbtn{flex:1;padding:13px;border-radius:13px;font-size:14px;font-weight:700;cursor:pointer;border:none;transition:all .2s;}
        .mbtn-cancel{background:rgba(255,255,255,.06);color:var(--text-muted);}
        .mbtn-cancel:hover{background:rgba(255,255,255,.1);color:var(--text-main);}
        .mbtn-save{background:linear-gradient(135deg,#6366f1,#ec4899);color:#fff;box-shadow:0 8px 20px rgba(99,102,241,.35);}
        .mbtn-save:hover{box-shadow:0 12px 28px rgba(99,102,241,.5);transform:translateY(-1px);}
        /* Toast */
        .toast{position:fixed;bottom:28px;left:50%;transform:translateX(-50%) translateY(20px);background:rgba(15,20,40,.96);border:1px solid rgba(99,102,241,.35);color:var(--text-main);padding:12px 22px;border-radius:100px;font-size:13px;font-weight:600;z-index:2000;opacity:0;transition:all .3s;pointer-events:none;white-space:nowrap;}
        .toast.show{opacity:1;transform:translateX(-50%) translateY(0);}
    </style>
</head>
<body>
<div class="ambient-glow"><div class="glow-1"></div><div class="glow-2"></div></div>

<header>
    <div class="hbrand">
        <div class="hicon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>
        </div>
        <div class="htext"><h1>Webji Audio Pro</h1><span>High Fidelity Audio Experience</span></div>
    </div>
    <div class="upanel">
        <div class="uinfo">
            <div class="uavatar">{{ substr(Auth::user()->name ?? 'U', 0, 1) }}</div>
            <div class="uname">{{ Auth::user()->name ?? 'Listener' }}</div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Keluar
            </button>
        </form>
    </div>
</header>

<main>
  <div class="left-col">
    <section class="player-stage">
      <div class="badge"><span class="pdot"></span><span>Lossless 320kbps &bull; Web Audio API</span></div>
      <div class="vis-wrap">
        <div class="vinyl-wrap">
          <div class="vinyl" id="vinylDisc">
            <div class="vinyl-inner">
              <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="10 8 16 12 10 16 10 8" fill="#fff"/></svg>
            </div>
          </div>
        </div>
        <canvas id="vizCanvas" class="vizcanvas"></canvas>
        <div class="tdetails">
          <h2 class="ttitle" id="trackTitle">Pilih Lagu</h2>
          <p class="tartist" id="trackArtist">Webji Music Collection</p>
        </div>
      </div>
      <div class="playback-controls">
        <div class="timeline">
          <div class="pbar-wrap" id="pbarWrap"><div class="pbar-fill" id="pbarFill"></div></div>
          <div class="tlabels"><span id="curTime">00:00</span><span id="durTime">00:00</span></div>
        </div>
        <div class="ctrls">
          <button class="cbtn" id="shuffleBtn" title="Acak" onclick="toggleShuffle()">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 3h5v5"/><path d="M4 20L21 3"/><path d="M21 16v5h-5"/><path d="M15 15l6 6"/><path d="M4 4l5 5"/></svg>
          </button>
          <button class="cbtn" id="prevBtn" title="Sebelumnya" onclick="prevTrack()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="19 20 9 12 19 4 19 20"/><line x1="5" y1="19" x2="5" y2="5"/></svg>
          </button>
          <button class="cbtn cbtn-play" id="playBtn" title="Putar/Jeda" onclick="togglePlay()">
            <svg id="playIcon" width="26" height="26" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20 6 4"/></svg>
          </button>
          <button class="cbtn" id="nextBtn" title="Selanjutnya" onclick="nextTrack()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="5 4 15 12 5 20 5 4"/><line x1="19" y1="5" x2="19" y2="19"/></svg>
          </button>
          <button class="cbtn" id="repeatBtn" title="Ulangi" onclick="toggleRepeat()">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
          </button>
        </div>
        <div class="bbar">
          <div class="vol-ctrl">
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
            <input type="range" class="vol-slider" id="volSlider" min="0" max="1" step="0.01" value="0.8" oninput="chVol(this.value)">
          </div>
          <button class="eq-btn" id="eqBtn" onclick="toggleEqPanel()">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
            Equalizer
          </button>
        </div>
      </div>
    </section>

    <!-- Equalizer Panel -->
    <div class="eq-panel" id="eqPanel">
      <div class="eq-hdr">
        <div class="eq-hdr-l">
          <span class="eq-title">&#127923; Equalizer 10-Band</span>
          <div class="eq-en-wrap">
            <label class="tswitch"><input type="checkbox" id="eqEn" checked onchange="toggleEqEn()"><span class="tslider"></span></label>
            <span id="eqEnLbl">Aktif</span>
          </div>
        </div>
        <button class="eq-reset" onclick="resetEq()">&#8617; Reset Flat</button>
      </div>
      <div class="eq-presets">
        <button class="eq-pb active" onclick="applyPreset('flat',this)">Flat</button>
        <button class="eq-pb" onclick="applyPreset('bass',this)">Bass Boost</button>
        <button class="eq-pb" onclick="applyPreset('rock',this)">Rock</button>
        <button class="eq-pb" onclick="applyPreset('pop',this)">Pop</button>
        <button class="eq-pb" onclick="applyPreset('jazz',this)">Jazz</button>
        <button class="eq-pb" onclick="applyPreset('classical',this)">Classical</button>
        <button class="eq-pb" onclick="applyPreset('electronic',this)">Electronic</button>
        <button class="eq-pb" onclick="applyPreset('vocal',this)">Vocal</button>
        <button class="eq-pb" onclick="applyPreset('lofi',this)">Lo-Fi</button>
      </div>
      <div class="eq-bands" id="eqBands"></div>
      <div class="eq-extra">
        <div class="eq-eg"><label class="eq-el"><span>Sub-Bass (60Hz)</span><span id="sbVal">0 dB</span></label><input type="range" class="eq-es" id="sbSlider" min="-15" max="15" step="0.5" value="0" oninput="updSB(this.value)"></div>
        <div class="eq-eg"><label class="eq-el"><span>Presence / Air (10kHz)</span><span id="prVal">0 dB</span></label><input type="range" class="eq-es" id="prSlider" min="-12" max="12" step="0.5" value="0" oninput="updPR(this.value)"></div>
        <div class="eq-eg"><label class="eq-el"><span>Master Gain</span><span id="mgVal">0 dB</span></label><input type="range" class="eq-es" id="mgSlider" min="-20" max="12" step="0.5" value="0" oninput="updMG(this.value)"></div>
      </div>
    </div>
  </div>

  <!-- Sidebar -->
  <aside class="playlist-panel">
    <div class="ptabs">
      <button class="ptab active" id="tabPlaylist" onclick="switchTab('Playlist')">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><circle cx="3" cy="6" r="1" fill="currentColor"/><circle cx="3" cy="12" r="1" fill="currentColor"/><circle cx="3" cy="18" r="1" fill="currentColor"/></svg>
        Playlist
      </button>
      <button class="ptab" id="tabAdd" onclick="switchTab('Add')">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah
      </button>
    </div>

    <div class="tabcon active" id="contentPlaylist">
      <div class="plhdr">
        <div class="plhdr-l"><span class="plhdr-title">Daftar Putar</span><span class="plcount" id="plCount">3 Lagu</span></div>
        <button class="pladd-btn" onclick="openAddModal()">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>Tambah
        </button>
      </div>
      <ul class="tlist" id="trackList"></ul>
      <div class="upbox" onclick="document.getElementById('lfi1').click()">
        <span class="uplabel">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          Unggah File MP3 Lokal
        </span>
        <input type="file" id="lfi1" class="upinput" accept="audio/*" onchange="handleFile(event)" multiple>
      </div>
    </div>

    <div class="tabcon" id="contentAdd">
      <div class="addform">
        <div class="addform-title">+ Tambah Lagu ke Playlist</div>
        <div class="ffield"><label class="flabel">Judul Lagu</label><input class="finput" id="afTitle" type="text" placeholder="Contoh: Starlight"></div>
        <div class="ffield"><label class="flabel">Nama Artis</label><input class="finput" id="afArtist" type="text" placeholder="Contoh: Muse"></div>
        <div class="ffield"><label class="flabel">URL Audio (MP3 / OGG / WAV)</label><input class="finput" id="afUrl" type="url" placeholder="https://example.com/audio.mp3"></div>
        <button class="fsubmit" onclick="addFromForm()">+ Tambahkan ke Playlist</button>
        <div class="divdr"><div class="divdr-line"></div><span class="divdr-txt">atau</span><div class="divdr-line"></div></div>
        <div class="upbox" onclick="document.getElementById('lfi2').click()">
          <span class="uplabel">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            Pilih File MP3 dari Komputer
          </span>
          <input type="file" id="lfi2" class="upinput" accept="audio/*" onchange="handleFile(event)" multiple>
        </div>
      </div>
    </div>
  </aside>
</main>

<!-- Edit/Add Modal -->
<div class="moverlay" id="trackModal">
  <div class="mcard">
    <div class="mtitle">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      <span id="mTitleTxt">Tambah Lagu</span>
    </div>
    <div class="mfield"><label>Judul Lagu</label><input class="minput" id="mTitle" placeholder="Judul" type="text"></div>
    <div class="mfield"><label>Nama Artis</label><input class="minput" id="mArtist" placeholder="Artis" type="text"></div>
    <div class="mfield"><label>URL Audio</label><input class="minput" id="mUrl" placeholder="https://..." type="url"></div>
    <div class="mfooter">
      <button class="mbtn mbtn-cancel" onclick="closeModal()">Batal</button>
      <button class="mbtn mbtn-save" onclick="saveModal()">Simpan</button>
    </div>
  </div>
</div>

<div class="toast" id="toast"></div>
<audio id="audioEl" preload="metadata" crossorigin="anonymous"></audio>

<script>
// DATA
let PL=[
  {title:"Ambient Dreamscape",       artist:"Webji Soundlab",    dur:"03:45", url:"https://www.soundhelix.com/examples/mp3/SoundHelix-Song-1.mp3"},
  {title:"Electronic Pulse Session", artist:"Retro Wave Studio", dur:"07:05", url:"https://www.soundhelix.com/examples/mp3/SoundHelix-Song-2.mp3"},
  {title:"Midnight Lo-Fi Chill",     artist:"Acoustic Beats",    dur:"05:43", url:"https://www.soundhelix.com/examples/mp3/SoundHelix-Song-3.mp3"}
];
let ci=0,playing=false,shuffle=false,repeat=false,mMode='add',editI=-1;

const aud=document.getElementById('audioEl');
const pIcon=document.getElementById('playIcon');
const vinyl=document.getElementById('vinylDisc');
const ttitle=document.getElementById('trackTitle');
const tartist=document.getElementById('trackArtist');
const pbFill=document.getElementById('pbarFill');
const pbWrap=document.getElementById('pbarWrap');
const ctEl=document.getElementById('curTime');
const dtEl=document.getElementById('durTime');
const tlistEl=document.getElementById('trackList');
const cvs=document.getElementById('vizCanvas');
const c2=cvs.getContext('2d');

// AUDIO
let actx,analyser,src,gain,sb,pr,eqF=[],vReady=false,eqOn=true;
const EQB=[32,64,125,250,500,1000,2000,4000,8000,16000];
const EQLN=['32Hz','64Hz','125Hz','250Hz','500Hz','1kHz','2kHz','4kHz','8kHz','16kHz'];
const PRE={
  flat:      [0,0,0,0,0,0,0,0,0,0],
  bass:      [8,7,6,4,1,0,0,0,0,0],
  rock:      [5,4,3,1,-1,0,1,3,4,4],
  pop:       [-1,0,2,4,5,4,2,0,-1,-2],
  jazz:      [4,3,1,2,-1,-1,0,1,3,4],
  classical: [5,4,3,2,0,-1,-1,0,3,4],
  electronic:[6,5,0,2,0,0,2,3,4,5],
  vocal:     [-2,-2,0,4,5,4,3,1,0,-2],
  lofi:      [3,3,2,0,-1,-2,-3,-4,-5,-6]
};

function initAudio(){
  if(vReady)return;
  try{
    actx=new(window.AudioContext||window.webkitAudioContext)();
    analyser=actx.createAnalyser();
    gain=actx.createGain();
    src=actx.createMediaElementSource(aud);
    sb=actx.createBiquadFilter();sb.type='lowshelf';sb.frequency.value=60;sb.gain.value=0;
    pr=actx.createBiquadFilter();pr.type='highshelf';pr.frequency.value=10000;pr.gain.value=0;
    eqF=EQB.map((f,i)=>{const n=actx.createBiquadFilter();n.type=i===0?'lowshelf':i===EQB.length-1?'highshelf':'peaking';n.frequency.value=f;n.gain.value=0;n.Q.value=1.2;return n;});
    const ch=[sb,...eqF,pr,gain,analyser];
    src.connect(ch[0]);
    for(let i=0;i<ch.length-1;i++)ch[i].connect(ch[i+1]);
    analyser.connect(actx.destination);
    analyser.fftSize=128;
    vReady=true;
    buildEqUI();
    drawViz();
  }catch(e){console.warn(e);}
}

function drawViz(){
  requestAnimationFrame(drawViz);
  if(!analyser)return;
  const bl=analyser.frequencyBinCount,da=new Uint8Array(bl);
  analyser.getByteFrequencyData(da);
  cvs.width=cvs.offsetWidth;cvs.height=cvs.offsetHeight;
  c2.clearRect(0,0,cvs.width,cvs.height);
  const bw=(cvs.width/bl)*1.6;let x=0;
  for(let i=0;i<bl;i++){
    const bh=(da[i]/255)*cvs.height*.92;
    const g2=c2.createLinearGradient(0,cvs.height,0,0);
    g2.addColorStop(0,'#6366f1');g2.addColorStop(1,'#ec4899');
    c2.fillStyle=g2;c2.beginPath();c2.roundRect(x,cvs.height-bh,bw-3,bh,4);c2.fill();
    x+=bw;
  }
}

// EQ UI
function buildEqUI(){
  const c=document.getElementById('eqBands');c.innerHTML='';
  EQB.forEach((_,i)=>{
    const d=document.createElement('div');d.className='eq-band';
    d.innerHTML=`<div class="eq-bval" id="ev${i}">0 dB</div>
      <div class="eq-bwrap"><div class="eq-zline"></div>
      <input type="range" class="eq-bs" id="es${i}" min="-15" max="15" step="0.5" value="0" oninput="updBand(${i},this.value)"></div>
      <div class="eq-bfreq">${EQLN[i]}</div>`;
    c.appendChild(d);
  });
}
function dbl(v){return(v>=0?'+':'')+parseFloat(v).toFixed(1)+' dB';}
function updBand(i,v){
  v=parseFloat(v);
  document.getElementById('ev'+i).textContent=dbl(v);
  if(eqF[i]&&eqOn)eqF[i].gain.value=v;
  document.querySelectorAll('.eq-pb').forEach(b=>b.classList.remove('active'));
}
function toggleEqEn(){
  eqOn=document.getElementById('eqEn').checked;
  document.getElementById('eqEnLbl').textContent=eqOn?'Aktif':'Nonaktif';
  if(!eqF.length)return;
  eqF.forEach((f,i)=>{f.gain.value=eqOn?parseFloat(document.getElementById('es'+i)?.value||0):0;});
  if(sb)sb.gain.value=eqOn?parseFloat(document.getElementById('sbSlider').value):0;
  if(pr)pr.gain.value=eqOn?parseFloat(document.getElementById('prSlider').value):0;
  toast(eqOn?'Equalizer ON':'Equalizer OFF');
}
function applyPreset(n,btn){
  const g=PRE[n]||PRE.flat;
  g.forEach((v,i)=>{const s=document.getElementById('es'+i);if(s){s.value=v;updBand(i,v);}});
  document.querySelectorAll('.eq-pb').forEach(b=>b.classList.remove('active'));
  if(btn)btn.classList.add('active');
  toast('Preset: '+(btn?btn.textContent:n));
}
function resetEq(){
  applyPreset('flat',document.querySelector('.eq-pb'));
  ['sbSlider','prSlider','mgSlider'].forEach(id=>document.getElementById(id).value=0);
  updSB(0);updPR(0);updMG(0);toast('EQ direset ke Flat');
}
function updSB(v){v=parseFloat(v);document.getElementById('sbVal').textContent=dbl(v);if(sb&&eqOn)sb.gain.value=v;}
function updPR(v){v=parseFloat(v);document.getElementById('prVal').textContent=dbl(v);if(pr&&eqOn)pr.gain.value=v;}
function updMG(v){v=parseFloat(v);document.getElementById('mgVal').textContent=dbl(v);if(gain)gain.gain.value=Math.pow(10,v/20);}
function toggleEqPanel(){
  const p=document.getElementById('eqPanel'),b=document.getElementById('eqBtn');
  const o=p.classList.toggle('open');b.classList.toggle('active',o);
}

// PLAYLIST
function esc(s){const d=document.createElement('div');d.appendChild(document.createTextNode(s));return d.innerHTML;}
let ds=-1;
function renderPL(){
  tlistEl.innerHTML='';
  PL.forEach((t,i)=>{
    const li=document.createElement('li');
    li.className='titem'+(i===ci?' active':'');
    li.draggable=true;li.dataset.i=i;
    li.innerHTML=`
      <div class="dhandle" title="Geser"><svg width="12" height="12" viewBox="0 0 24 24"><circle cx="9" cy="7" r="1.2" fill="#94a3b8"/><circle cx="9" cy="12" r="1.2" fill="#94a3b8"/><circle cx="9" cy="17" r="1.2" fill="#94a3b8"/><circle cx="15" cy="7" r="1.2" fill="#94a3b8"/><circle cx="15" cy="12" r="1.2" fill="#94a3b8"/><circle cx="15" cy="17" r="1.2" fill="#94a3b8"/></svg></div>
      <div class="tnum">${i===ci&&playing?'<div class="eqbars"><span class="eqbar"></span><span class="eqbar"></span><span class="eqbar"></span></div>':i+1}</div>
      <div class="tinfo" onclick="selTrack(${i})">
        <div class="tname">${esc(t.title)}</div>
        <div class="tartist2">${esc(t.artist)}</div>
      </div>
      <div class="tdur">${t.dur||'--:--'}</div>
      <div class="tactions">
        <button class="tact-btn edit" title="Edit" onclick="openEdit(${i})"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
        <button class="tact-btn" title="Hapus" onclick="delTrack(${i})"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg></button>
      </div>`;
    li.addEventListener('dragstart',e=>{ds=i;li.classList.add('dragging');e.dataTransfer.effectAllowed='move';});
    li.addEventListener('dragover',e=>{e.preventDefault();li.classList.add('drag-over');});
    li.addEventListener('dragleave',()=>li.classList.remove('drag-over'));
    li.addEventListener('dragend',()=>renderPL());
    li.addEventListener('drop',e=>{
      e.preventDefault();const di=parseInt(li.dataset.i);
      if(ds===di)return;
      const mv=PL.splice(ds,1)[0];PL.splice(di,0,mv);
      if(ds===ci)ci=di;else if(ds<ci&&di>=ci)ci--;else if(ds>ci&&di<=ci)ci++;
      renderPL();toast('Urutan diperbarui');
    });
    tlistEl.appendChild(li);
  });
  document.getElementById('plCount').textContent=PL.length+' Lagu';
}

// PLAYBACK
function loadTrack(idx,play=false){
  ci=idx;const t=PL[idx];
  aud.src=t.url;aud.load();
  ttitle.textContent=t.title;tartist.textContent=t.artist;
  pbFill.style.width='0%';ctEl.textContent='00:00';playing=false;
  renderPL();
  if(play){aud.addEventListener('canplay',function h(){aud.removeEventListener('canplay',h);initAudio();if(actx&&actx.state==='suspended')actx.resume();aud.play().catch(e=>console.warn(e));},{once:true});}
}
function togglePlay(){
  initAudio();if(actx&&actx.state==='suspended')actx.resume();
  if(playing){aud.pause();}
  else{if(!aud.src||aud.src===location.href){loadTrack(ci,true);return;}aud.play().catch(e=>console.warn(e));}
}
function selTrack(i){loadTrack(i,true);}
function nextTrack(){const w=playing;ci=shuffle?Math.floor(Math.random()*PL.length):(ci+1)%PL.length;loadTrack(ci,w);}
function prevTrack(){const w=playing;ci=(ci-1+PL.length)%PL.length;loadTrack(ci,w);}
function toggleShuffle(){shuffle=!shuffle;document.getElementById('shuffleBtn').classList.toggle('active',shuffle);toast(shuffle?'Acak ON':'Acak OFF');}
function toggleRepeat(){repeat=!repeat;document.getElementById('repeatBtn').classList.toggle('active',repeat);toast(repeat?'Ulangi ON':'Ulangi OFF');}
function chVol(v){aud.volume=v;}

aud.onplay=()=>{playing=true;vinyl.classList.add('playing');pIcon.innerHTML='<rect x="6" y="4" width="4" height="16" rx="1"/><rect x="14" y="4" width="4" height="16" rx="1"/>';renderPL();};
aud.onpause=()=>{playing=false;vinyl.classList.remove('playing');pIcon.innerHTML='<polygon points="6 4 20 12 6 20 6 4"/>';renderPL();};
aud.ontimeupdate=()=>{if(aud.duration){pbFill.style.width=(aud.currentTime/aud.duration*100)+'%';ctEl.textContent=fmt(aud.currentTime);dtEl.textContent=fmt(aud.duration);}};
aud.onended=()=>{if(repeat){aud.currentTime=0;aud.play();}else nextTrack();};
pbWrap.addEventListener('click',e=>{if(aud.duration)aud.currentTime=(e.offsetX/pbWrap.clientWidth)*aud.duration;});

// CRUD
function openAddModal(){
  mMode='add';document.getElementById('mTitleTxt').textContent='+ Tambah Lagu';
  ['mTitle','mArtist','mUrl'].forEach(id=>document.getElementById(id).value='');
  document.getElementById('trackModal').classList.add('open');
  setTimeout(()=>document.getElementById('mTitle').focus(),280);
}
function openEdit(i){
  mMode='edit';editI=i;document.getElementById('mTitleTxt').textContent='Edit Lagu';
  const t=PL[i];
  document.getElementById('mTitle').value=t.title;
  document.getElementById('mArtist').value=t.artist;
  document.getElementById('mUrl').value=t.url;
  document.getElementById('trackModal').classList.add('open');
  setTimeout(()=>document.getElementById('mTitle').focus(),280);
}
function closeModal(){document.getElementById('trackModal').classList.remove('open');}
function saveModal(){
  const title=document.getElementById('mTitle').value.trim();
  const artist=document.getElementById('mArtist').value.trim()||'Tidak diketahui';
  const url=document.getElementById('mUrl').value.trim();
  if(!title||!url){toast('Judul dan URL wajib!');return;}
  if(mMode==='add'){PL.push({title,artist,dur:'--:--',url});renderPL();toast('Ditambahkan: '+title);}
  else{PL[editI]={...PL[editI],title,artist,url};if(editI===ci){ttitle.textContent=title;tartist.textContent=artist;}renderPL();toast('Diperbarui: '+title);}
  closeModal();
}
function delTrack(i){
  const nm=PL[i].title;PL.splice(i,1);
  if(!PL.length){aud.pause();playing=false;ttitle.textContent='Playlist kosong';tartist.textContent='';renderPL();return;}
  if(i===ci)loadTrack(Math.min(i,PL.length-1),playing);
  else{if(i<ci)ci--;renderPL();}
  toast('Dihapus: '+nm);
}
function addFromForm(){
  const title=document.getElementById('afTitle').value.trim();
  const artist=document.getElementById('afArtist').value.trim()||'Tidak diketahui';
  const url=document.getElementById('afUrl').value.trim();
  if(!title||!url){toast('Judul dan URL wajib!');return;}
  PL.push({title,artist,dur:'--:--',url});renderPL();switchTab('Playlist');
  ['afTitle','afArtist','afUrl'].forEach(id=>document.getElementById(id).value='');
  toast('Ditambahkan: '+title);
}
function handleFile(e){
  const fs=Array.from(e.target.files);if(!fs.length)return;
  const fi=PL.length;
  fs.forEach(f=>PL.push({title:f.name.replace(/\.[^/.]+$/,''),artist:'File Lokal',dur:'--:--',url:URL.createObjectURL(f)}));
  renderPL();loadTrack(fi,true);toast(fs.length+' file ditambahkan');e.target.value='';
}

// TABS
function switchTab(tab){
  document.querySelectorAll('.tabcon').forEach(c=>c.classList.remove('active'));
  document.querySelectorAll('.ptab').forEach(b=>b.classList.remove('active'));
  document.getElementById('content'+tab).classList.add('active');
  document.getElementById('tab'+tab).classList.add('active');
}

// Modal keyboard
document.addEventListener('keydown',e=>{
  if(e.key==='Escape')closeModal();
  if(e.key==='Enter'&&document.getElementById('trackModal').classList.contains('open'))saveModal();
});
document.getElementById('trackModal').addEventListener('click',e=>{if(e.target===document.getElementById('trackModal'))closeModal();});

// Toast
let tT;
function toast(msg){const t=document.getElementById('toast');t.textContent=msg;t.classList.add('show');clearTimeout(tT);tT=setTimeout(()=>t.classList.remove('show'),2800);}
function fmt(s){if(isNaN(s))return'00:00';const m=Math.floor(s/60),ss=Math.floor(s%60);return(m<10?'0'+m:m)+':'+(ss<10?'0'+ss:ss);}

loadTrack(0);
</script>
</body>
</html>