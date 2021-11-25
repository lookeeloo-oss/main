<?php include 'db_connect.php' ?>
<?php
 function getIPAddress() {  
    //whether ip is from the share internet  
     if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
                $ip = $_SERVER['HTTP_CLIENT_IP'];  
        }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
     }  
//whether ip is from the remote address  
    else{  
             $ip = $_SERVER['REMOTE_ADDR'];  
     }  
     return $ip;  
}  
$upload = $conn->query("SELECT up.*,concat(u.firstname,' ',u.lastname) as name,u.avatar FROM uploads up inner join users u on u.id =up.user_id where up.code = '{$_GET['code']}' ");
foreach ($upload->fetch_array() as $k => $v) {
	$$k = $v;
}
if(isset($_SESSION['login_id'])){
	if($_SESSION['login_id'] != $user_id){
		$chk = $conn->query("SELECT * FROM views where upload_id = $id and user_id ={$_SESSION['login_id']} ")->num_rows;
		if($chk <= 0){
			$conn->query("INSERT INTO views set upload_id = $id , user_id = {$_SESSION['login_id']}");
		}
	}
}else{
	$ip = getIPAddress();
	$chk = $conn->query("SELECT * FROM views where upload_id = $id and ip_address ='$ip' ")->num_rows;
	if($chk <= 0){
		$conn->query("INSERT INTO views set upload_id = $id , ip_address = '$ip'");
	}

}
$views = $conn->query("SELECT * FROM views where upload_id = $id ")->num_rows;
$conn->query("UPDATE uploads set total_views = $views where id = $id");
 ?>
 <style type="text/css">
 	.suggested-img{
 		width: calc(30%);
 		height: 15vh;
 		display:flex;
 		justify-content: center;
 		align-items: center;
 		background: black
 	}
 	.suggested-details{
 		width: calc(70%);
 	}
 	.suggested-img video{
 		width: calc(100%);
 		height: calc(100%);
 	}
 	.suggested:hover{
 		background: #00adff1c;
 	}
 	#vid-watch{
 		max-height: 80vh
 	}
	 :root {
  --youtube-red: #FE0900;
}

html {
  box-sizing: border-box;
  font-family: "YouTube Noto",Roboto,Arial,Helvetica,sans-serif;
  height: 100%;
}

*, *::before, *::after {
  box-sizing: inherit;
  margin: 0;
  padding: 0;
}

body {
  height: 100%;
}

.container {
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.video-container {
  width: 800px;
  border-radius: 4px;
  margin: 0 auto;
  position: relative;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

video {
  width: 100%;
  height: 100%;
  border-radius: 4px;
}

.video-controls {
  right: 0;
  left: 0;
  padding: 10px;
  position: absolute;
  bottom: 0;
  transition: all 0.2s ease;
  background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5));
}

.video-controls.hide {
  opacity: 0;
  pointer-events: none;
}

.video-progress {
  position: relative;
  height: 8.4px;
  margin-bottom: 10px;
}

progress {
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  border-radius: 2px;
  width: 100%;
  height: 8.4px;
  pointer-events: none;
  position: absolute;
  top: 0;
}

progress::-webkit-progress-bar {
  background-color: #474545;
  border-radius: 2px;
}

progress::-webkit-progress-value {
  background: var(--youtube-red);
  border-radius: 2px;
}

progress::-moz-progress-bar {
  border: 1px solid var(--youtube-red);
  background: var(--youtube-red);
}

.seek {
  position: absolute;
  top: 0;
  width: 100%;
  cursor: pointer;
  margin: 0;
}

.seek:hover+.seek-tooltip {
  display: block;
}

.seek-tooltip {
  display: none;
  position: absolute;
  top: -50px;
  margin-left: -20px;
  font-size: 12px;
  padding: 3px;
  content: attr(data-title);
  font-weight: bold;
  color: #fff;
  background-color: rgba(0, 0, 0, 0.6);
}

.bottom-controls {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.left-controls {
  display: flex;
  align-items: center;
  color: #fff;
}

.volume-controls {
  display: flex;
  align-items: center;
  margin-right: 10px;
}

.volume-controls input {
  width: 100px;
  opacity: 1;
  transition: all 0.4s ease;
}

.volume-controls:hover input, .volume-controls input:focus {
  width: 100px;
  opacity: 1;
}

button {
  cursor: pointer;
  position: relative;
  margin-right: 7px;
  font-size: 12px;
  padding: 3px;
  border: none;
  outline: none;
  background-color: transparent;
}

button * {
  pointer-events: none;
}

button::before {
  content: attr(data-title);
  position: absolute;
  display: none;
  right: 0;
  top: -50px;
  background-color: rgba(0, 0, 0, 0.6);
  color: #fff;
  font-weight: bold;
  padding: 4px 6px;
  word-break: keep-all;
  white-space: pre;
}

button:hover::before {
  display: inline-block;
}

.fullscreen-button {
  margin-right: 0;
}

.pip-button svg {
  width: 26px;
  height: 26px;
}

.playback-animation {
  pointer-events: none;
  position: absolute;
  top: 50%;
  left: 50%;
  margin-left: -40px;
  margin-top: -40px;
  width: 80px;
  height: 80px;
  border-radius: 80px;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  opacity: 0;
}

input[type=range] {
  -webkit-appearance: none;
  -moz-appearance: none;
  height: 8.4px;
  background: transparent;
  cursor: pointer;
}

input[type=range]:focus {
  outline: none;
}

input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  cursor: pointer;
  border-radius: 1.3px;
  -webkit-appearance: none;
  transition: all 0.4s ease;
}

input[type=range]::-webkit-slider-thumb {
  height: 16px;
  width: 16px;
  border-radius: 16px;
  background: var(--youtube-red);
  cursor: pointer;
  -webkit-appearance: none;
  margin-left: -1px;
}

input[type=range]:focus::-webkit-slider-runnable-track {
  background: transparent;
}

input[type=range].volume {
  height: 5px;
  background-color: #fff;
}

input[type=range].volume::-webkit-slider-runnable-track {
  background-color: transparent;
}

input[type=range].volume::-webkit-slider-thumb {
  margin-left: 0;
  height: 14px;
  width: 14px;
  background: #fff;
}

input[type=range]::-moz-range-track {
  width: 100%;
  height: 8.4px;
  cursor: pointer;
  border: 1px solid transparent;
  background: transparent;
  border-radius: 1.3px;
}

input[type=range]::-moz-range-thumb {
  height: 14px;
  width: 14px;
  border-radius: 50px;
  border: 1px solid var(--youtube-red);
  background: var(--youtube-red);
  cursor: pointer;
  margin-top: 5px;
}

input[type=range]:focus::-moz-range-track {
  outline: none;
}

input[type=range].volume::-moz-range-thumb {
  border: 1px solid #fff;
  background: #fff;
}

.hidden {
  display: none;
}

svg {
  width: 28px;
  height: 28px;
  fill: #fff;
  stroke: #fff;
  cursor: pointer;
}
 </style>
<div class="container-fluid py-2">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-8">
            <div class="d-block w-100 vid-watch-feild bg-dark border border-dark p-0" style="border-width: 2px">
							<video class="w-100" autoplay="true" controls id="vid-watch">
								<source src="<?php echo "assets/uploads/videos/".$video_path ?>">
							</video>
						</div>
						<div class="col-md-12 py-2">
							<div class="row">
								<h5 class="text-dark"><b><?php echo $title ?></b></h5>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row">
								<span class="badge badge-white"><b><?php echo date("M d, Y",strtotime($date_created)) ?></b></span>
								<span class="badge badge-primary"><b><?php echo $views.($views > 1 ? ' views':' view') ?></b></span>
							</div>
						</div>
						<hr>
						<div class="col-md-12">
							<div class="d-flex w-100 align-items-center">
								<?php if(!empty($avatar)): ?>
									<img src="assets/uploads/<?php echo $avatar ?>" class="rounded-circle" width="50px" height="50px" alt="">
								<?php else: ?>
									<span class="d-flex justify-content-center bg-primary align-items center rounded-circle border py-2 px-3" ><h3 class="text-white m-0"><b><?php echo substr($name,0,1) ?></h3></b></span>
								<?php endif; ?>
									<h6 class="mx-3"><b><?php echo $name ?></b></h6>
							</div>
							<h5><b>Description</b></h5>
							<p><?php echo str_replace(array("\n","\r"),'<br/>',$description) ?></p>
						</div>
					</div>
					<div class="col-md-4 border-left">
						<?php 
							$qry = $conn->query("SELECT * FROM uploads where id !=$id order by total_views asc,rand() limit 10");
							while($row= $qry->fetch_assoc()):
						?>
						<a class="d-flex w-100 border-bottom pb-1 suggested" href="index.php?page=watch&code=<?php echo $row['code'] ?>">
							<div class="img-thumbnail suggested-img border-dark border" poster="assets/uploads/thumbnail/<?php echo $row['thumbnail_path'] ?>">
								<video class="img-fluid" id="<?php echo $row['code'] ?>" muted>
									<source src="assets/uploads/videos/<?php echo $row['video_path'] ?>" alt="" >
								</video>
							</div>
							<div class="suggested-details px-2 py-2">
								<h6 class="truncate-2 text-dark"><b><?php echo $row['title'] ?></b></h6>
								<small class="text-muted"><i>Posted:<?php echo date("M, d Y",strtotime($row['date_created'])) ?></i></small>
							</div>
						</a>
						<?php endwhile; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('.suggested').hover(function(){
		$(this).addClass('active')
		var vid = $(this).find('video')
		var id = vid.get(0).id;
			setTimeout(function(){
				vid.trigger('play')
				document.getElementById(id).playbackRate = 2.0
			},500)
	})
	$('.suggested').mouseout(function(){
		var vid = $(this).find('video')
			setTimeout(function(){
				vid.trigger('pause')
			},500)
	})
	// Select elements here
	const video = document.getElementById('video');
const videoControls = document.getElementById('video-controls');
const playButton = document.getElementById('play');
const playbackIcons = document.querySelectorAll('.playback-icons use');
const timeElapsed = document.getElementById('time-elapsed');
const duration = document.getElementById('duration');
const progressBar = document.getElementById('progress-bar');
const seek = document.getElementById('seek');
const seekTooltip = document.getElementById('seek-tooltip');
const volumeButton = document.getElementById('volume-button');
const volumeIcons = document.querySelectorAll('.volume-button use');
const volumeMute = document.querySelector('use[href="#volume-mute"]');
const volumeLow = document.querySelector('use[href="#volume-low"]');
const volumeHigh = document.querySelector('use[href="#volume-high"]');
const volume = document.getElementById('volume');
const playbackAnimation = document.getElementById('playback-animation');
const fullscreenButton = document.getElementById('fullscreen-button');
const videoContainer = document.getElementById('video-container');
const fullscreenIcons = fullscreenButton.querySelectorAll('use');
const pipButton = document.getElementById('pip-button');

const videoWorks = !!document.createElement('video').canPlayType;
if (videoWorks) {
  video.controls = false;
  videoControls.classList.remove('hidden');
}

// Add functions here

// togglePlay toggles the playback state of the video.
// If the video playback is paused or ended, the video is played
// otherwise, the video is paused
function togglePlay() {
  if (video.paused || video.ended) {
    video.play();
  } else {
    video.pause();
  }
}

// updatePlayButton updates the playback icon and tooltip
// depending on the playback state
function updatePlayButton() {
  playbackIcons.forEach((icon) => icon.classList.toggle('hidden'));

  if (video.paused) {
    playButton.setAttribute('data-title', 'Play (k)');
  } else {
    playButton.setAttribute('data-title', 'Pause (k)');
  }
}

// formatTime takes a time length in seconds and returns the time in
// minutes and seconds
function formatTime(timeInSeconds) {
  const result = new Date(timeInSeconds * 1000).toISOString().substr(11, 8);

  return {
    minutes: result.substr(3, 2),
    seconds: result.substr(6, 2),
  };
}

// initializeVideo sets the video duration, and maximum value of the
// progressBar
function initializeVideo() {
  const videoDuration = Math.round(video.duration);
  seek.setAttribute('max', videoDuration);
  progressBar.setAttribute('max', videoDuration);
  const time = formatTime(videoDuration);
  duration.innerText = `${time.minutes}:${time.seconds}`;
  duration.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`);
}

// updateTimeElapsed indicates how far through the video
// the current playback is by updating the timeElapsed element
function updateTimeElapsed() {
  const time = formatTime(Math.round(video.currentTime));
  timeElapsed.innerText = `${time.minutes}:${time.seconds}`;
  timeElapsed.setAttribute('datetime', `${time.minutes}m ${time.seconds}s`);
}

// updateProgress indicates how far through the video
// the current playback is by updating the progress bar
function updateProgress() {
  seek.value = Math.floor(video.currentTime);
  progressBar.value = Math.floor(video.currentTime);
}

// updateSeekTooltip uses the position of the mouse on the progress bar to
// roughly work out what point in the video the user will skip to if
// the progress bar is clicked at that point
function updateSeekTooltip(event) {
  const skipTo = Math.round(
    (event.offsetX / event.target.clientWidth) *
      parseInt(event.target.getAttribute('max'), 10)
  );
  seek.setAttribute('data-seek', skipTo);
  const t = formatTime(skipTo);
  seekTooltip.textContent = `${t.minutes}:${t.seconds}`;
  const rect = video.getBoundingClientRect();
  seekTooltip.style.left = `${event.pageX - rect.left}px`;
}

// skipAhead jumps to a different point in the video when the progress bar
// is clicked
function skipAhead(event) {
  const skipTo = event.target.dataset.seek ? event.target.dataset.seek : event.target.value; 
  video.currentTime = skipTo;
  progressBar.value = skipTo;
  seek.value = skipTo;
}

// updateVolume updates the video's volume
// and disables the muted state if active
function updateVolume() {
  if (video.muted) {
    video.muted = false;
  }

  video.volume = volume.value;
}

// updateVolumeIcon updates the volume icon so that it correctly reflects
// the volume of the video
function updateVolumeIcon() {
  volumeIcons.forEach((icon) => {
    icon.classList.add('hidden');
  });

  volumeButton.setAttribute('data-title', 'Mute (m)');

  if (video.muted || video.volume === 0) {
    volumeMute.classList.remove('hidden');
    volumeButton.setAttribute('data-title', 'Unmute (m)');
  } else if (video.volume > 0 && video.volume <= 0.5) {
    volumeLow.classList.remove('hidden');
  } else {
    volumeHigh.classList.remove('hidden');
  }
}

// toggleMute mutes or unmutes the video when executed
// When the video is unmuted, the volume is returned to the value
// it was set to before the video was muted
function toggleMute() {
  video.muted = !video.muted;

  if (video.muted) {
    volume.setAttribute('data-volume', volume.value);
    volume.value = 0;
  } else {
    volume.value = volume.dataset.volume;
  }
}

// animatePlayback displays an animation when
// the video is played or paused
function animatePlayback() {
  playbackAnimation.animate(
    [
      {
        opacity: 1,
        transform: 'scale(1)',
      },
      {
        opacity: 0,
        transform: 'scale(1.3)',
      },
    ],
    {
      duration: 500,
    }
  );
}

// toggleFullScreen toggles the full screen state of the video
// If the browser is currently in fullscreen mode,
// then it should exit and vice versa.
function toggleFullScreen() {
  if (document.fullscreenElement) {
    document.exitFullscreen();
  } else if (document.webkitFullscreenElement) {
    // Need this to support Safari
    document.webkitExitFullscreen();
  } else if (videoContainer.webkitRequestFullscreen) {
    // Need this to support Safari
    videoContainer.webkitRequestFullscreen();
  } else {
    videoContainer.requestFullscreen();
  }
}

// updateFullscreenButton changes the icon of the full screen button
// and tooltip to reflect the current full screen state of the video
function updateFullscreenButton() {
  fullscreenIcons.forEach((icon) => icon.classList.toggle('hidden'));

  if (document.fullscreenElement) {
    fullscreenButton.setAttribute('data-title', 'Exit full screen (f)');
  } else {
    fullscreenButton.setAttribute('data-title', 'Full screen (f)');
  }
}

// togglePip toggles Picture-in-Picture mode on the video
async function togglePip() {
  try {
    if (video !== document.pictureInPictureElement) {
      pipButton.disabled = true;
      await video.requestPictureInPicture();
    } else {
      await document.exitPictureInPicture();
    }
  } catch (error) {
    console.error(error);
  } finally {
    pipButton.disabled = false;
  }
}

// hideControls hides the video controls when not in use
// if the video is paused, the controls must remain visible
function hideControls() {
  if (video.paused) {
    return;
  }

  videoControls.classList.add('hide');
}

// showControls displays the video controls
function showControls() {
  videoControls.classList.remove('hide');
}

// keyboardShortcuts executes the relevant functions for
// each supported shortcut key
function keyboardShortcuts(event) {
  const { key } = event;
  switch (key) {
    case 'k':
      togglePlay();
      animatePlayback();
      if (video.paused) {
        showControls();
      } else {
        setTimeout(() => {
          hideControls();
        }, 2000);
      }
      break;
    case 'm':
      toggleMute();
      break;
    case 'f':
      toggleFullScreen();
      break;
    case 'p':
      togglePip();
      break;
  }
}

// Add eventlisteners here
playButton.addEventListener('click', togglePlay);
video.addEventListener('play', updatePlayButton);
video.addEventListener('pause', updatePlayButton);
video.addEventListener('loadedmetadata', initializeVideo);
video.addEventListener('timeupdate', updateTimeElapsed);
video.addEventListener('timeupdate', updateProgress);
video.addEventListener('volumechange', updateVolumeIcon);
video.addEventListener('click', togglePlay);
video.addEventListener('click', animatePlayback);
video.addEventListener('mouseenter', showControls);
video.addEventListener('mouseleave', hideControls);
videoControls.addEventListener('mouseenter', showControls);
videoControls.addEventListener('mouseleave', hideControls);
seek.addEventListener('mousemove', updateSeekTooltip);
seek.addEventListener('input', skipAhead);
volume.addEventListener('input', updateVolume);
volumeButton.addEventListener('click', toggleMute);
fullscreenButton.addEventListener('click', toggleFullScreen);
videoContainer.addEventListener('fullscreenchange', updateFullscreenButton);
pipButton.addEventListener('click', togglePip);

document.addEventListener('DOMContentLoaded', () => {
  if (!('pictureInPictureEnabled' in document)) {
    pipButton.classList.add('hidden');
  }
});
document.addEventListener('keyup', keyboardShortcuts);
</script>