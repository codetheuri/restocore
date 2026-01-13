<?php


?>

<div class="row">
    <div class="col-md-6 col-sm-6">
        <div class="card mb-0">
            <div class="card-header">
                <div class="row align-center">
                    <div class="col">
                        <h5 class="card-title">Recent Invoices</h5>
                    </div>
                    <div class="col-auto">
                        <a href="invoices.html" class="btn-right btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="progress progress-md rounded-pill mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 47%" aria-valuenow="47"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 28%" aria-valuenow="28"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 15%" aria-valuenow="15"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <i class="fas fa-circle text-success me-1"></i> Paid
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-circle text-warning me-1"></i> Unpaid
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-circle text-danger me-1"></i> Overdue
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-circle text-info me-1"></i> Draft
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-stripped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-04.jpg" alt="User Image" />Barbara Moore</a>
                                    </h2>
                                </td>
                                <td>$118</td>
                                <td>23 Nov 2020</td>
                                <td>
                                    <span class="badge bg-success-light">Paid</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone
                                                Invoice</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-06.jpg" alt="User Image" />Karlene Chaidez</a>
                                    </h2>
                                </td>
                                <td>$222</td>
                                <td>18 Nov 2020</td>
                                <td>
                                    <span class="badge bg-info-light text-info">Sent</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone
                                                Invoice</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-08.jpg" alt="User Image" />Russell Copeland</a>
                                    </h2>
                                </td>
                                <td>$347</td>
                                <td>10 Nov 2020</td>
                                <td>
                                    <span class="badge bg-warning-light text-warning">Partially Paid</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone
                                                Invoice</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-10.jpg" alt="User Image" />Joseph Collins</a>
                                    </h2>
                                </td>
                                <td>$826</td>
                                <td>25 Sep 2020</td>
                                <td>
                                    <span class="badge bg-danger-light">Overdue</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone
                                                Invoice</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-11.jpg" alt="User Image" />Jennifer Floyd</a>
                                    </h2>
                                </td>
                                <td>$519</td>
                                <td>18 Sep 2020</td>
                                <td>
                                    <span class="badge bg-success-light">Paid</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i class="far fa-copy me-2"></i>Clone
                                                Invoice</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6">
        <div class="card mb-0">
            <div class="card-header">
                <div class="row align-center">
                    <div class="col">
                        <h5 class="card-title">Recent Estimates</h5>
                    </div>
                    <div class="col-auto">
                        <a href="invoice-details.html" class="btn-right btn btn-sm btn-outline-primary">
                            View All
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="progress progress-md rounded-pill mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 39%" aria-valuenow="39"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35"
                            aria-valuemin="0" aria-valuemax="100"></div>
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 26%" aria-valuenow="26"
                            aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="row">
                        <div class="col-auto">
                            <i class="fas fa-circle text-success me-1"></i> Sent
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-circle text-warning me-1"></i> Draft
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-circle text-danger me-1"></i> Expired
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>Customer</th>
                                <th>Expiry Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-05.jpg" alt="User Image" />
                                            Greg Lynch</a>
                                    </h2>
                                </td>
                                <td>5 Nov 2020</td>
                                <td>$175</td>
                                <td>
                                    <span class="badge bg-info-light text-info">Sent</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-file-alt me-2"></i>Convert
                                                to Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Estimate</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as Accepted</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-times-circle me-2"></i>Mark
                                                as Rejected</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-06.jpg" alt="User Image" />
                                            Karlene Chaidez</a>
                                    </h2>
                                </td>
                                <td>28 Oct 2020</td>
                                <td>$1500</td>
                                <td>
                                    <span class="badge bg-warning-light text-warning">Expired</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-file-alt me-2"></i>Convert
                                                to Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Estimate</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as Accepted</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-times-circle me-2"></i>Mark
                                                as Rejected</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-07.jpg" alt="User Image" />
                                            John Blair</a>
                                    </h2>
                                </td>
                                <td>17 Oct 2020</td>
                                <td>$2350</td>
                                <td>
                                    <span class="badge bg-success-light">Accepted</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-file-alt me-2"></i>Convert
                                                to Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Estimate</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as Accepted</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-times-circle me-2"></i>Mark
                                                as Rejected</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-08.jpg" alt="User Image" />
                                            Russell Copeland</a>
                                    </h2>
                                </td>
                                <td>8 Oct 2020</td>
                                <td>$1890</td>
                                <td>
                                    <span class="badge bg-success-light">Accepted</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-file-alt me-2"></i>Convert
                                                to Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Estimate</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as Accepted</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-times-circle me-2"></i>Mark
                                                as Rejected</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="table-avatar">
                                        <a href="profile.html"><img class="avatar avatar-sm me-2 avatar-img rounded-circle"
                                                src="assets/img/profiles/avatar-09.jpg" alt="User Image" />
                                            Leatha Bailey</a>
                                    </h2>
                                </td>
                                <td>30 Sep 2020</td>
                                <td>$785</td>
                                <td>
                                    <span class="badge bg-success-light">Accepted</span>
                                </td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="index.html#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown"
                                            aria-expanded="false"><i class="fas fa-ellipsis-h"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="edit-invoice.html"><i class="far fa-edit me-2"></i>Edit</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-trash-alt me-2"></i>Delete</a>
                                            <a class="dropdown-item" href="invoice-details.html"><i
                                                    class="far fa-eye me-2"></i>View</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-file-alt me-2"></i>Convert
                                                to Invoice</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as sent</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-paper-plane me-2"></i>Send
                                                Estimate</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-check-circle me-2"></i>Mark
                                                as Accepted</a>
                                            <a class="dropdown-item" href="javascript:void(0);"><i
                                                    class="far fa-times-circle me-2"></i>Mark
                                                as Rejected</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>