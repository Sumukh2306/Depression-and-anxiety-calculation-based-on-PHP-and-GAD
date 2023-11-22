function playPause(audio) {
  if (audio.paused) {
    audio.play();
  } else {
    audio.pause();
const ratingEl = document.getElementById('rating');
const randomRating = Math.floor(Math.random() * 5) + 1;
ratingEl.textContent = randomRating;
  }
}


