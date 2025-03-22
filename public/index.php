<?php if (empty($users)): ?>
<p class="lead mt-3">There is no list</p>
<?php endif; ?>

<?php foreach ($users as $index => $user) { ?>
<tr>
  <th scope="row"><?php echo $index + 1; ?></th>
  <td><?php echo htmlspecialchars($user['username']) ?></td>
  <td><?php echo htmlspecialchars($user['role']) ?></td>
  <td>
    <button class="btn btn-primary editUser" data-id="<?php echo $user['id']; ?>"
      data-username="<?php echo htmlspecialchars($user['username']); ?>"
      data-role="<?php echo htmlspecialchars($user['role']); ?>">
      Edit
    </button>
    <button class="btn btn-danger">Delete</button>
  </td>
</tr>
<?php } ?>