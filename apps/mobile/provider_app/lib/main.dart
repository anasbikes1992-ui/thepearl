import 'package:flutter/material.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';

import 'core/router/app_router.dart';
import 'core/theme/app_theme.dart';

void main() {
  runApp(const ProviderScope(child: ProviderApp()));
}

class ProviderApp extends StatelessWidget {
  const ProviderApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp.router(
      debugShowCheckedModeBanner: false,
      title: 'PearlHub Provider',
      theme: providerTheme(),
      routerConfig: providerRouter(),
    );
  }
}
