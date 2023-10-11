import Swal from 'sweetalert2';

export default {
    showToast(icon, title) {
      let background = 'white';
      if(icon == 'error') {
        background = '#DC3545'
      } else {
        background = '#1AAA55'
      }
      Swal.fire({
        toast: true,
        icon: icon,
        title: title,
        showConfirmButton: false,
        timer: 2500,
        background: background,
        position: 'top-end',
        color: 'white'
      });
    },
}
