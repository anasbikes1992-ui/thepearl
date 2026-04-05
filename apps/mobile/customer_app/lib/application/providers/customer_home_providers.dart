import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../data/models/dashboard_item.dart';
import '../../data/repositories/customer_home_repository.dart';

final customerHomeRepositoryProvider = Provider<CustomerHomeRepository>((ref) {
  return CustomerHomeRepository();
});

final customerHomeCardsProvider = FutureProvider<List<DashboardItem>>((ref) async {
  final repository = ref.watch(customerHomeRepositoryProvider);
  return repository.fetchHomeCards();
});
