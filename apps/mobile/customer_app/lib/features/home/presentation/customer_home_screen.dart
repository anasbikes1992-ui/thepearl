import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import '../../../application/providers/customer_home_providers.dart';

class CustomerHomeScreen extends ConsumerWidget {
  const CustomerHomeScreen({super.key});

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final cards = ref.watch(customerHomeCardsProvider);

    return Scaffold(
      appBar: AppBar(title: const Text('PearlHub Customer')),
      body: cards.when(
        data: (items) => ListView(
          padding: const EdgeInsets.all(16),
          children: [
            for (final item in items)
              Card(
                child: ListTile(
                  title: Text(item.title),
                  subtitle: Text(item.subtitle),
                ),
              ),
          ],
        ),
        loading: () => const Center(child: CircularProgressIndicator()),
        error: (error, _) => Center(child: Text('Failed to load dashboard: $error')),
      ),
    );
  }
}
