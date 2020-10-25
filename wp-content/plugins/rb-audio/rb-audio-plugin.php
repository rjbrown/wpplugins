<?php
/**
 * Plugin Name: RB-AUDIO-RECORDER
 * Plugin URI: http://www.getuwired.com
 * Description: This plugin allows you to drop a shortcode anywhere you need the user to record and upload audio.
 * Version: 1.0.0
 */
 
  
defined( 'ABSPATH' ) or die();
wp_enqueue_script("jquery");
wp_enqueue_script("jquery-effects-core");
wp_enqueue_script("jquery-ui-core");
wp_enqueue_script("jquery-ui-draggable");
wp_enqueue_script( 'rb-audio', plugins_url() . '/rb-audio/js/rb-audio.js', array('jquery', 'jquery-ui-draggable'), '0.1' );


function rb_audio( $tmp ){

?>	
<style>
#rbAudioRecorder{
	display: inline-block;
	text-align: center;
	position: absolute;
	top: 25%;
	left: 0;
	width:350px;
	background-color: rgba(0,0,0,0.6);
	border-radius: 20px;
	padding: 20px;
	color: white;
}
#rbAudioRecorder input[type="button"]{

	color: black;
}

audio{
	width: 100%;
}
#rbAudioRecorder input[type="button"]{
	display: inline-block;
	text-align: center;
}
</style>

	<div id="rbAudioRecorder">

		<input id="hiddenAudio" type="hidden" name="audioStore" value="" />
		<div>
			<audio controls></audio>
			<fieldset><legend>RECORD AUDIO</legend>
				<input onclick="startRecording()" type="button" value="Start recording" />
				<input onclick="stopRecording()" type="button" value="Stop recording" />
				<a id="download" href="#" download="submission.wav" target="_blank"><input type="button" value="Download"/></a>
			</fieldset>
		</div>
		
				
		<script>
			
			var urlRvf = "<?php echo plugins_url(); ?>/rb-audio/js/rb-audio.js";
			var onFail = function(e) {
				console.log('Rejected!', e);
			};

			var onSuccess = function(s) {
				var context = new (window.AudioContext || window.webkitAudioContext)();
				var mediaStreamSource = context.createMediaStreamSource(s);
				console.log(mediaStreamSource);
				recorder = new Recorder(urlRvf, mediaStreamSource);
				recorder.record();

			}

			window.URL = window.URL || window.webkitURL;
			navigator.getUserMedia  = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;

			var recorder;
			var audio = document.querySelector('audio');
			var linker = document.getElementById('download');

			function startRecording() {
				if (navigator.getUserMedia) {
					navigator.getUserMedia({audio: true}, onSuccess, onFail);
				} else {
					console.log('navigator.getUserMedia not present');
				}
			}

			function stopRecording() {
				recorder.stop();
				recorder.exportWAV(function(s) {
					audio.src = window.URL.createObjectURL(s);
					uploadAudioFromBlob();
				});
			}
			
			function downloadRecordedAudio() {
				recorder.forceDownload(audio.src, 'test.wav');
			}
			
			
			
			function uploadAudioFromBlob(){
				console.log(recorder.audioBlobber);
				var haudio = document.getElementById('hiddenAudio');
				
				
				var myBlob = new Blob();
				var xhr = new XMLHttpRequest();
				xhr.open('GET', audio.src, true);
				xhr.responseType = 'blob';
				xhr.onload = function(e) {
				  if (this.status == 200) {
					  myBlob = this.response;
					  fr = new FileReader();
					  fr.onload = (function (theBlob) {
						return function(e){
							haudio.value = e.target.result;
							linker.href = e.target.result;
							console.log(e.target.result);
						};
					  })(myBlob);
					fr.readAsDataURL(myBlob);
					// myBlob is now the blob that the object URL pointed to.
				  }
				};
				xhr.send();
			}
			
			
		</script>
		<script>
			jQuery(function($){
				$('#rbAudioRecorder').draggable();
			});
		</script>
		
		<input type="file" accept="audio/*;capture=microphone">
	
	</div>
<?php
}

add_shortcode( 'rbaudio', 'rb_audio' );


