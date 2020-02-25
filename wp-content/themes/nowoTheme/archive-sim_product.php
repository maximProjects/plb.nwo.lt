<?php get_header(); ?>

<section>

	<div class="container">

		<h2 class="title section-header">
			<span><?php echo get_the_title(); ?></span>
		</h2>


		<div class="content-container service-container">
			<div class="row">

				<div class="col-md-12">

					<div class="content">
						<?php echo is_page() ? apply_filters('the_content', get_the_content()) : ''; ?>
					</div>
					<?php $i = 0; ?>

					<ul class="nav nav-tabs product-tabs">
						<?php foreach(SIM_Product::get_list() as $service): ?>
							<li role="presentation" class="<?php echo $i++ == 0 ? 'active' : ''; ?>"><a href="#<?php echo $service->post->post_name; ?>"><?php echo $service->post->post_title; ?></a></li>
						<?php endforeach; ?>
					</ul>

					<!-- Tab panes -->
					<?php $k = 0; ?>
					<div class="tab-content page-content">
						<?php foreach(SIM_Product::get_list() as $service): ?>
							<div role="tabpanel" class="tab-pane <?php echo $k++ == 0 ? 'active' : ''; ?>" id="<?php echo $service->post->post_name; ?>">

								<div class="row">

									<div class="col-md-12">
										<img src="<?php echo apply_filters('post_image_url', $service->id, 'full'); ?>" class="img-responsive title-image hidden-xs" alt="">
									</div>
									
									<div class="col-md-8">
										<div class="content">
											<?php echo is_page() ? apply_filters('the_content', $service->post->post_content) : ''; ?>

											<a href="" class="btn btn-exclusive extra" data-toggle="modal" data-target="#requestModal_<?php echo $service->post->post_name; ?>">
												<?php echo __('Get quote', 'nowotheme'); ?>
											</a>
										</div>

										<!-- Modal -->
										<div class="modal fade" id="requestModal_<?php echo $service->post->post_name; ?>" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel">
											<div class="modal-dialog" role="document">

												<a type="button" class="btn pull-right modal-close" data-dismiss="modal">
													<img src="<?php echo get_template_directory_uri() . '/img/icons/svg/plus.svg' ?>" alt="">
												</a>

												<div class="modal-content form-container">
													<div class="form-block form-exclusive">

														<h1 class="heading"><?php echo $service->post->post_title; ?></h1>

														<?php echo do_shortcode('[contact-form-7 id="267" title="U?klausos forma"]'); ?>

													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-4">

										<div class="row">
											<?php $documents = get_field('sim_document_attachment', $service->id); ?>
											<?php if($documents): ?>
												<div class="col-sm-6 col-md-12">
													<div class="documents-container box-bg-container">
														<h4 class="title"><?php echo __('Documents', 'nowotheme'); ?>:</h4>

														<div class="">
															<?php foreach($documents as $document): ?>
																<div class="document">
																	<h4 class="title"><?php echo $document->post_title; ?></h4>
																	<?php echo do_shortcode("[download-attachments post_id='" . $document->ID . "' container_class='attachment-list']"); ?>

																</div>
															<?php endforeach; ?>
														</div>
													</div>
												</div>
											<?php endif; ?>


											<?php $assigned_employee = get_field('sim_service_employee', $service->id); ?>

											<?php if($assigned_employee): ?>

												<?php $employee = SIM_Employee::getById($assigned_employee->ID); ?>

												<div class="col-sm-6 col-md-12">
													<div class="employee-container box-bg-container">

														<h4 class="title"><?php echo __('Lorem ipsum', 'nowotheme'); ?>:</h4>

														<div class="info-title">
															<div class="icon">
																<a href="" class="" data-toggle="modal" data-target="#employeeModal_<?php echo $service->id . '_' . $employee->post->post_name; ?>">
																	<img src="<?php echo get_template_directory_uri() . '/img/icons/svg/info.svg' ?>" alt="">
																</a>
															</div>
															<div class="links">
																<a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
															</div>
														</div>

														<div class="contacts-block">
															<div class="info name"><strong><?php echo $employee->employee_name ?> <?php echo $employee->employee_surname ?></strong></div>
															<div class="info position"><?php echo $employee->get_position(); ?></div>
															<div class='info phone'><?php echo sprintf("<span class=''><a href='tel:%s'>%s</a></span>", $employee->employee_phone, $employee->employee_phone); ?></div>
															<div class='info email'><?php echo sprintf("<span class=''><a href='mailto:%s'>%s</a></span>", $employee->employee_email, $employee->employee_email); ?></div>
														</div>
													</div>
												</div>
												<!-- Modal -->
												<div class="modal fade" id="employeeModal_<?php echo $service->id . '_' . $employee->post->post_name; ?>" tabindex="-1" role="dialog" aria-labelledby="requestModalLabel">
													<div class="modal-dialog employee" role="document">

														<a type="button" class="btn pull-right modal-close" data-dismiss="modal">
															<img src="<?php echo get_template_directory_uri() . '/img/icons/svg/plus.svg' ?>" alt="">
														</a>

														<div class="modal-content">

															<h1 class="heading"><?php echo $employee->employee_name ?> <?php echo $employee->employee_surname ?></h1>

															<div class="row">
																<div class="col-md-5">
																	<div class="employee-container">
																		<?php if(apply_filters('post_image_url', $employee->id, 'medium')): ?>
																			<img src="<?php echo apply_filters('post_image_url', $employee->id, 'article_list_medium'); ?>" class="img-responsive" alt="">
																		<?php endif; ?>

																		<div class="info-title">
																			<div class="icon">
																				<i class="fa fa-info-circle" aria-hidden="true"></i> <span>Info</span>
																			</div>
																			<div class="links">
																				<a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>
																			</div>
																		</div>

																		<div class="contacts-block">
																			<div class="info name"><strong><?php echo $employee->employee_name ?> <?php echo $employee->employee_surname ?></strong></div>
																			<div class="info position"><?php echo $employee->get_position(); ?></div>
																			<div class='info phone'><?php echo sprintf("<span class=''><a href='tel:%s'>%s</a></span>", $employee->employee_phone, $employee->employee_phone); ?></div>
																			<div class='info email'><?php echo sprintf("<span class=''><a href='mailto:%s'>%s</a></span>", $employee->employee_email, $employee->employee_email); ?></div>
																		</div>
																	</div>
																</div>
																<div class="col-md-7">
																	<?php echo apply_filters('the_content', $employee->post->post_content); ?>
																</div>
															</div>
														</div>
													</div>
												</div>

											<?php endif; ?>
										</div>

									</div>
								</div>

							</div>
						<?php endforeach; ?>
					</div>
				</div>

			</div>
		</div>

	</div>


</section>


<?php get_footer(); ?>