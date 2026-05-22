const items = document.querySelectorAll(".task_delete");

items.forEach((el) => {
    el.addEventListener("click",(event)=> {
    const result = confirm("削除しますか？");
    if(!result) {
        event.preventDefault();
    }
});
})

const edit_btn = document.querySelectorAll(".task_edit");
const modal = document.getElementById("modal");
const closeModal = document.getElementById("closeModal");


closeModal.addEventListener("click", () => {
  modal.classList.add("hidden");
});

edit_btn.forEach(button => {
  button.addEventListener('click', function () { 
    modal.classList.remove("hidden");
    document.getElementById('modal_id').value = this.dataset.id;
    document.getElementById('modal_task').value = this.dataset.title;
    document.getElementById('modal_content').value = this.dataset.content;
    document.getElementById('modal_task_date').value = this.dataset.taskdate;
    document.getElementById('modal_time_h').value = this.dataset.timeh;
    document.getElementById('modal_time_m').value = this.dataset.timem;
    document.getElementById('modal_status').value = this.dataset.status;
    document.getElementById('modal_priority').value = this.dataset.priority;
  });
});

document.querySelectorAll("input[name='status[]']").forEach(cb => {
  cb.addEventListener("change", () => {
    document.getElementById("filterForm").submit();
  });
});