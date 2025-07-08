<?php
// app/Filters/AdminAuthFilter.php
// Filter ini memastikan pengguna yang login memiliki peran 'admin'.

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return ResponseInterface|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Pastikan user sudah login
        if (! session()->get('isLoggedIn')) {
            return redirect()->to(base_url('login'));
        }

        // Pastikan user memiliki role 'admin'
        if (session()->get('role') !== 'admin') {
            // Jika bukan admin, redirect ke halaman utama user atau tampilkan error
            return redirect()->to(base_url('/'))->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    /**
     * We aren't concerned with after filters as they are
     * rarely used.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
