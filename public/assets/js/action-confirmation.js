$('body').on('click', '.action-confirmation', function () {
  const btn = $(this);
  const url = $(this).data('url');
  const title = btn.data('title') ?? 'Are you sure?';
  const text = btn.data('text') ?? "You won't be able to revert this!";
  const icon = btn.data('icon') ?? 'warning';
  const type = btn.data('type') ?? 'DELETE';
  const payload = btn.data('payload') ?? {}; // json formatted payload
  const confirmButtonText = btn.data('confirm-btn-text') ?? 'Yes';
  const confirmButtonColor = btn.data('confirm-btn-color') ?? 'red';
  const cancelButtonText = btn.data('cancel-btn-text') ?? 'Cancel';
  const cancelButtonColor = btn.data('cancel-btn-color') ?? 'blue';
  const data =
    typeof payload === 'string'
      ? JSON.parse(payload.replaceAll("'", '"'))
      : payload;

  if (!url) {
    /* eslint-disable-next-line */
    console.error('[ActionConfirmation]: No url found!');
    return;
  }

  const colors = {
    blue: '#3085d6',
    yellow: '#F8BB86',
    red: '#d33',
  };

  /* eslint-disable-next-line */
  Swal.fire({
    title,
    text,
    icon,
    showCancelButton: true,
    confirmButtonColor: colors[confirmButtonColor],
    cancelButtonColor: colors[cancelButtonColor],
    confirmButtonText,
    cancelButtonText,
  }).then((result) => {
    if (result.isConfirmed) {
      /* eslint-disable-next-line */
      new Ajax(url, type, data).send();
    }
  });
});
