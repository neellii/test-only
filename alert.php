<style>
.alert {
  z-index: 100;
  background-color: white;
  animation-name: fadeOut;
  animation-delay: 3s;
  animation-duration: 1s;
  animation-fill-mode: forwards;
  width: 100%;
  height: 30px;
  padding: 5px;
  position: absolute;
  top: 0;
  left: 0;
  text-align: center;
  color: #4070f4;
}
@keyframes fadeOut {
  from {opacity: 1; z-index: 500;}
  to {opacity: 0; z-index: -10;}
}
</style>

<div class="alert">
  <?= $_SESSION['alert'] ?>
</div>