<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container courses-index">
	<h1>Khám Phá Khóa Học</h1>

	<div class="search-and-filter">
		<form method="get" action="index.php" class="search-form">
			<input type="hidden" name="controller" value="course">
			<input type="hidden" name="action" value="index">
			
			<div class="search-box">
				<input type="text" name="q" placeholder="Tìm kiếm khóa học..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
				<button type="submit" class="btn-search">🔍 Tìm kiếm</button>
			</div>

			<?php if (!empty($categories)): ?>
				<div class="filter-box">
					<select name="category" onchange="this.form.submit();">
						<option value="">Tất cả danh mục</option>
						<?php foreach ($categories as $cat): ?>
							<option value="<?php echo $cat['id']; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : ''; ?>>
								<?php echo htmlspecialchars($cat['name']); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>
			<?php endif; ?>
		</form>
	</div>

	<?php if (!empty($courses)): ?>
		<div class="courses-summary">
			<p>Tìm thấy <strong><?php echo count($courses); ?></strong> khóa học</p>
		</div>

		<div class="courses-grid">
			<?php
				$enrolledIds = isset($enrolledIds) ? $enrolledIds : [];
				foreach ($courses as $c):
					$already = in_array($c['id'], $enrolledIds);
			?>
				<div class="course-card">
					<div class="course-image">
						<div class="placeholder">📚</div>
					</div>

					<div class="course-body">
						<h3><?php echo htmlspecialchars($c['title']); ?></h3>
						
						<p class="course-description">
							<?php echo htmlspecialchars(substr($c['description'], 0, 100)); ?>
							<?php echo strlen($c['description']) > 100 ? '...' : ''; ?>
						</p>

						<div class="course-footer">
							<div class="course-actions">
								<a href="index.php?controller=course&action=detail&id=<?php echo $c['id']; ?>" class="btn btn-secondary">Chi tiết</a>
								
								<?php if ($already): ?>
									<button disabled class="btn btn-disabled">✓ Đã đăng ký</button>
								<?php else: ?>
									<form method="post" action="index.php?controller=course&action=enroll" style="display:inline;">
										<input type="hidden" name="course_id" value="<?php echo $c['id']; ?>">
										<button type="submit" class="btn btn-primary">Đăng ký</button>
									</form>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div class="no-courses-message">
			<h2>Không tìm thấy khóa học</h2>
			<p>Rất tiếc, không có khóa học nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
			<p>
				<a href="index.php?controller=course&action=index">Xem tất cả khóa học</a> |
				<a href="index.php?controller=student&action=dashboard">Quay lại Dashboard</a>
			</p>
		</div>
	<?php endif; ?>

	<?php if (isset($_SESSION['user_id'])): ?>
		<div class="user-actions">
			<a href="index.php?controller=student&action=myCourses" class="btn btn-secondary">Xem khóa học của tôi</a>
		</div>
	<?php else: ?>
		<div class="login-prompt">
			<p>Vui lòng <a href="index.php?controller=auth&action=login">đăng nhập</a> hoặc <a href="index.php?controller=auth&action=register">đăng ký</a> để đăng ký khóa học.</p>
		</div>
	<?php endif; ?>
</div>

<style>
	.courses-index {
		padding: 20px;
	}

	.search-and-filter {
		background: white;
		padding: 25px;
		border-radius: 8px;
		margin-bottom: 30px;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}

	.search-form {
		display: grid;
		gap: 15px;
	}

	.search-box {
		display: flex;
		gap: 10px;
	}

	.search-box input[type="text"] {
		flex: 1;
		padding: 12px 16px;
		border: 2px solid #ddd;
		border-radius: 4px;
		font-size: 14px;
		transition: border-color 0.3s;
	}

	.search-box input[type="text"]:focus {
		outline: none;
		border-color: #667eea;
	}

	.btn-search {
		padding: 12px 24px;
		background: #667eea;
		color: white;
		border: none;
		border-radius: 4px;
		font-size: 14px;
		font-weight: 600;
		cursor: pointer;
		transition: background 0.3s;
		white-space: nowrap;
	}

	.btn-search:hover {
		background: #764ba2;
	}

	.filter-box select {
		padding: 12px 16px;
		border: 2px solid #ddd;
		border-radius: 4px;
		font-size: 14px;
		background: white;
		cursor: pointer;
		transition: border-color 0.3s;
	}

	.filter-box select:focus {
		outline: none;
		border-color: #667eea;
	}

	.courses-summary {
		margin-bottom: 20px;
		color: #666;
		font-size: 14px;
	}

	.courses-grid {
		display: grid;
		grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
		gap: 20px;
		margin-bottom: 30px;
	}

	.course-card {
		background: white;
		border: 1px solid #ddd;
		border-radius: 8px;
		overflow: hidden;
		transition: transform 0.2s, box-shadow 0.2s;
		display: flex;
		flex-direction: column;
	}

	.course-card:hover {
		transform: translateY(-4px);
		box-shadow: 0 8px 16px rgba(0,0,0,0.1);
	}

	.course-image {
		width: 100%;
		height: 180px;
		background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.course-image .placeholder {
		font-size: 60px;
		opacity: 0.8;
	}

	.course-body {
		padding: 20px;
		display: flex;
		flex-direction: column;
		flex: 1;
	}

	.course-card h3 {
		margin: 0 0 10px 0;
		color: #333;
		font-size: 16px;
		line-height: 1.4;
	}

	.course-description {
		margin: 0 0 15px 0;
		color: #666;
		font-size: 13px;
		line-height: 1.5;
		flex: 1;
	}

	.course-footer {
		border-top: 1px solid #eee;
		padding-top: 15px;
	}

	.course-actions {
		display: flex;
		gap: 10px;
	}

	.btn {
		flex: 1;
		padding: 10px 12px;
		text-decoration: none;
		border: none;
		border-radius: 4px;
		font-size: 13px;
		font-weight: 600;
		cursor: pointer;
		text-align: center;
		transition: all 0.3s;
		white-space: nowrap;
	}

	.btn-primary {
		background: #667eea;
		color: white;
	}

	.btn-primary:hover {
		background: #764ba2;
	}

	.btn-secondary {
		background: #f0f0f0;
		color: #333;
	}

	.btn-secondary:hover {
		background: #e0e0e0;
	}

	.btn-disabled {
		background: #e8f5e9;
		color: #2e7d32;
		cursor: not-allowed;
		opacity: 0.8;
	}

	.no-courses-message {
		background: #f9f9f9;
		border: 2px dashed #ddd;
		border-radius: 8px;
		padding: 40px 20px;
		text-align: center;
		margin: 30px 0;
	}

	.no-courses-message h2 {
		margin: 0 0 10px 0;
		color: #333;
	}

	.no-courses-message p {
		margin: 10px 0;
		color: #666;
	}

	.no-courses-message a {
		color: #667eea;
		text-decoration: none;
		font-weight: 500;
	}

	.no-courses-message a:hover {
		text-decoration: underline;
	}

	.user-actions {
		text-align: center;
		margin-top: 30px;
	}

	.login-prompt {
		background: #cfe2ff;
		border: 1px solid #084298;
		border-radius: 8px;
		padding: 20px;
		text-align: center;
		margin-top: 30px;
		color: #084298;
	}

	.login-prompt a {
		color: #084298;
		font-weight: bold;
		text-decoration: none;
	}

	.login-prompt a:hover {
		text-decoration: underline;
	}

	@media (max-width: 768px) {
		.search-box {
			flex-direction: column;
		}

		.search-form {
			gap: 10px;
		}

		.courses-grid {
			grid-template-columns: 1fr;
		}

		.course-actions {
			flex-direction: column;
		}

		.btn {
			width: 100%;
		}
	}
</style>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

