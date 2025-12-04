<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container">
	<div class="dashboard-header">
		<h1>🎓 Khám Phá Khóa Học</h1>
		<p>Tìm kiếm và tham gia các khóa học thú vị</p>
	</div>

	<div class="search-and-filter">
		<form method="get" action="index.php" class="search-form">
			<input type="hidden" name="controller" value="course">
			<input type="hidden" name="action" value="index">
			
			<div style="display: grid; grid-template-columns: 1fr auto; gap: 12px; margin-bottom: 20px;">
				<div style="display: flex; gap: 8px;">
					<input type="text" name="q" placeholder="Tìm kiếm khóa học..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>" style="flex: 1;">
					<button type="submit" class="btn btn-primary" style="width: auto; padding: 12px 24px;">🔍 Tìm kiếm</button>
				</div>

				<?php if (!empty($categories)): ?>
					<select name="category" onchange="this.form.submit();" style="width: 250px;">
						<option value="">Tất cả danh mục</option>
						<?php foreach ($categories as $cat): ?>
							<option value="<?php echo $cat['id']; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : ''; ?>>
								<?php echo htmlspecialchars($cat['name']); ?>
							</option>
						<?php endforeach; ?>
					</select>
				<?php endif; ?>
			</div>
		</form>
	</div>

	<?php if (!empty($courses)): ?>
		<div style="margin: 24px 0; color: #666; font-size: 15px;">
			<p>✨ Tìm thấy <strong style="color: #667eea; font-size: 18px;"><?php echo count($courses); ?></strong> khóa học</p>
		</div>

		<div class="courses-grid">
			<?php
				$enrolledIds = isset($enrolledIds) ? $enrolledIds : [];
				foreach ($courses as $c):
					$already = in_array($c['id'], $enrolledIds);
			?>
				<div class="course-card">
					<img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 300 200'%3E%3Cdefs%3E%3ClinearGradient id='grad' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%23667eea;stop-opacity:1' /%3E%3Cstop offset='100%25' style='stop-color:%23764ba2;stop-opacity:1' /%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='300' height='200' fill='url(%23grad)'/%3E%3Ctext x='50%25' y='50%25' font-size='60' text-anchor='middle' dominant-baseline='middle' fill='white'%3E📚%3C/text%3E%3C/svg%3E" alt="<?php echo htmlspecialchars($c['title']); ?>">
					
					<h3><?php echo htmlspecialchars($c['title']); ?></h3>
					
					<p class="course-instructor">👨‍🏫 <?php echo htmlspecialchars($c['instructor_name'] ?? 'Không xác định'); ?></p>
					
					<p style="color: #666; font-size: 13px; line-height: 1.5;">
						<?php echo htmlspecialchars(substr($c['description'], 0, 80)); ?>
						<?php echo strlen($c['description']) > 80 ? '...' : ''; ?>
					</p>

					<div class="actions" style="margin-top: auto;">
						<a href="index.php?controller=course&action=detail&id=<?php echo $c['id']; ?>" class="btn btn-secondary" style="flex: 1; text-align: center;">Chi tiết</a>
						
						<?php if ($already): ?>
							<button disabled class="btn" style="flex: 1; background: #28a745; color: white; cursor: default; opacity: 0.8;">✓ Đã đăng ký</button>
						<?php else: ?>
							<form method="post" action="index.php?controller=course&action=enroll" style="flex: 1;">
								<input type="hidden" name="course_id" value="<?php echo $c['id']; ?>">
								<button type="submit" class="btn btn-primary" style="width: 100%;">Đăng ký</button>
							</form>
						<?php endif; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php else: ?>
		<div style="text-align: center; padding: 60px 20px; background: white; border-radius: 8px; margin: 40px 0;">
			<h2 style="font-size: 24px; color: #333; margin-bottom: 8px;">😔 Không tìm thấy khóa học</h2>
			<p style="color: #666; margin-bottom: 24px;">Rất tiếc, không có khóa học nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
			<div style="display: flex; gap: 12px; justify-content: center;">
				<a href="index.php?controller=course&action=index" class="btn btn-primary">Xem tất cả khóa học</a>
				<a href="index.php?controller=student&action=dashboard" class="btn btn-secondary">Quay lại Dashboard</a>
			</div>
		</div>
	<?php endif; ?>

	<?php if (isset($_SESSION['user_id'])): ?>
		<div style="text-align: center; margin-top: 40px;">
			<a href="index.php?controller=student&action=myCourses" class="btn btn-secondary" style="display: inline-block;">Xem khóa học của tôi</a>
		</div>
	<?php else: ?>
		<div style="text-align: center; padding: 30px; background: #e3f2fd; border-radius: 8px; margin: 40px 0;">
			<p style="font-size: 15px;">Vui lòng <a href="index.php?controller=auth&action=login" style="color: #667eea; font-weight: 500;">đăng nhập</a> hoặc <a href="index.php?controller=auth&action=register" style="color: #667eea; font-weight: 500;">đăng ký</a> để đăng ký khóa học.</p>
		</div>
	<?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

