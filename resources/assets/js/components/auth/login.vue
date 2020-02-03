<template>
  <div class="modal open">
    <div class="modal-content">
      <header class="modal-header">
        <h3>{{ title }}</h3>
        <span @click="close">&times;</span>
      </header>
      <article class="modal-body">
        <slot name="content"></slot>
      </article>
      <footer class="modal-footer">
        <slot name="actions"></slot>
      </footer>
    </div>
  </div>
</template>

<script>
export default {
    data (){
        return {
            title: "Modal Title yeah!",
        }
    }
}
</script>

<style scoped>
  .modal {
    align-items: flex-start;
    background-color: rgba(0,0,0,.75);
    display: flex;
    height: 100vh;
    justify-content: center;
    opacity: 0;
    position: fixed;
    transition: visibility 250ms, opacity 250ms;
    width: 100%;
    z-index: -1;
  }
  .modal.open {
    opacity: 1;
    visibility: visible;
    z-index: 2;
  }
  .modal.open .modal-content {
    transform: translateY(100px);
  }
  .modal-content {
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 8px 16px 0 rgba(0,0,0,.25);
    display: inline-block;
    min-width: 320px;
    max-width: 480px;
    transition: transform 450ms ease;
    width: 100%;
  }
  .modal-header {
    border-bottom: 1px solid #eee;
    padding: 20px;
    position: relative;
    text-align: center;
  }
  .modal-header h3 {
    color: #444;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
  }
  .modal-header span {
    cursor: pointer;
    font-weight: bolder;
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
  }
  .modal-body {
    padding: 40px;
  }
  .modal-footer {
    background-color: #f8f8f8;
    border-top: 1px solid #eee;
    display: flex;
    justify-content: flex-end;
    padding: 20px;
  }
</style>
