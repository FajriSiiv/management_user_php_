<?php
session_start();
include("../../layout/navbar.php");
include('../../actions/verify_id.php');

$sql = "SELECT * FROM users WHERE role='user'";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<div class="mt-4">
  <h2>Dashbord Admin <?php echo $_SESSION['success_message'] ?></h2>
  <h2 id="update_message"></h2>
  <?php if (empty($users)): ?>
  <p class="lead mt-3">There is no list</p>
  <?php endif; ?>
  <table class="table w-75 table-bordered border-primary mx-auto mt-4">
    <thead>
      <tr>
        <th scope="col" class="col-1">#</th>
        <th scope="col" class="col-6">Username</th>
        <th scope="col" class="col-2">Role</th>
        <th scope="col" class="col-3">Handle</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($users as $index => $user) { ?>
      <tr>
        <th scope="row"><?php echo $index + 1; ?></th>
        <td><?php echo htmlspecialchars($user['username']) ?></td>
        <td><?php echo htmlspecialchars($user['role']) ?></td>
        <td class="d-flex gap-2">
          <button class="btn btn-sm flex-grow-1 btn-primary editUser" style="height:fit-content;"
            data-id="<?php echo $user['id']; ?>" data-username="<?php echo htmlspecialchars($user['username']); ?>"
            data-role="<?php echo htmlspecialchars($user['role']); ?>">
            Edit
          </button>
          <form action="../../actions/user/delete_user.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $user['id'] ?>">
            <button type="submit" class="btn btn-sm flex-grow-1 btn-danger">Delete</button>
          </form>
        </td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm">
          <input type="hidden" id="userId">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" required>
            <div class="form-text" id="form-text"></div>
          </div>
          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <button type="submit" class="btn btn-success">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="toast-container position-fixed bottom-0 end-0 p-3">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">Website Message</strong>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      <p id="toast-message"></p>
      <div class="d-flex justify-content-between align-items-center ">
        <button type="button" class="btn btn-primary btn-sm" onclick="window.location.reload()">Reload</button>
        <p class="p-0 m-0">Refresh Data</p>
      </div>

    </div>

  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
  const toastLive = document.getElementById('liveToast')


  $(".editUser").click(function() {
    var userId = $(this).data("id");
    var username = $(this).data("username");
    var role = $(this).data("role");

    $("#userId").val(userId);
    $("#username").val(username);
    $("#role").val(role);

    $("#form-text").text("");
    $("#editModal").modal("show");
  });

  $("#editForm").submit(function(e) {
    e.preventDefault();

    var userId = $("#userId").val();
    var username = $("#username").val();
    var role = $("#role").val();


    $.ajax({
      url: "../../actions/user/update_user.php",
      type: "POST",
      data: {
        id: userId,
        username: username,
        role: role
      },
      success: function(response) {
        if (!response.success) {
          $("#form-text").text(response.message).css("color", "red");
        } else {

          const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive)
          toastBootstrap.show()

          $("#toast-message").text(response.message).css({
            "color": "green"
          });


          $("#editModal").modal("hide");
        }

      }
    });
  });
});
</script>

</body>

</html>



<?php
include("../../layout/footer.php");
?>